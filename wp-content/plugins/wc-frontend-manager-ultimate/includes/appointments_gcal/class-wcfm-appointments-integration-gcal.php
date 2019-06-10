<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * WC_Appointments_Integration_GCal.
 */
class WC_Appointments_Integration_GCal {

	/**
	 * @var WC_Appointments_Integration_GCal The single instance of the class
	 */
	protected static $_instance = null;

	/**
	 * Main WC_Appointments_Integration_GCal Instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * User ID not set by default.
	 */
	private $user_id = null;

	/**
	 * Init and hook in the integration.
	 */
	public function __construct() {
		// API.
		$this->id            = 'gcal';
		$this->oauth_uri     = 'https://accounts.google.com/o/oauth2/';
		$this->calendars_uri = 'https://www.googleapis.com/calendar/v3/calendars/';
		$this->api_scope     = 'https://www.googleapis.com/auth/calendar';
		$this->redirect_uri  = WC()->api_request_url( 'wc_appointments_oauth_redirect' );
		$this->callback_uri  = WC()->api_request_url( 'wc_appointments_callback_read' );

		$this->client_id     = get_option( 'wc_appointments_gcal_client_id' );
		$this->client_secret = get_option( 'wc_appointments_gcal_client_secret' );
		$this->calendar_id   = get_option( 'wc_appointments_gcal_calendar_id' );
		$this->debug         = get_option( 'wc_appointments_gcal_debug' );
		$this->twoway        = get_option( 'wc_appointments_gcal_twoway' );

		// Oauth redirect.
		add_action( 'woocommerce_api_wc_appointments_oauth_redirect', array( $this, 'oauth_redirect' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );

		// Enable 2-way sync.
		if ( $this->is_twoway_enabled() ) {
			// Sync from GCal.
			add_action( 'woocommerce_api_wc_appointments_callback_read', array( $this, 'callback_read' ) ); #live sync
			add_action( 'wc-appointment-sync-from-gcal', array( $this, 'sync_from_gcal' ) );
			add_filter( 'wc_appointments_global_availability', array( $this, 'sync_global_availability' ) );
			add_filter( 'wc_appointments_staff_availability', array( $this, 'sync_staff_availability' ), 10, 2 );

			// Schedule incremental sync each hour.
			if ( ! wp_next_scheduled( 'wc-appointment-sync-from-gcal' ) ) {
				wp_clear_scheduled_hook( 'wc-appointment-sync-from-gcal' );
				wp_schedule_event( time(), apply_filters( 'woocommerce_appointments_sync_from_gcal', 'hourly' ), 'wc-appointment-sync-from-gcal' );
			}
		}

		// Clean up gcal availaibility rules.
		$is_calendar_set   = $this->is_calendar_set();
		$is_twoway_enabled = $this->is_twoway_enabled();
		if ( ! $is_twoway_enabled || ! $is_calendar_set ) {

			// Delete cron and gcal availability.
			wp_clear_scheduled_hook( 'wc-appointment-sync-from-gcal' );
			delete_option( 'wc_appointments_gcal_availability' );
			delete_option( 'wc_appointments_gcal_availability_last_synced' );

		}

		// Sync all statuses, but limit inside maybe_sync_to_gcal_from_status() function.
		foreach ( get_wc_appointment_statuses() as $status ) {
			add_action( 'woocommerce_appointment_' . $status, array( $this, 'sync_new_appointment' ) );
		}

		// Remove from Gcal.
		add_action( 'woocommerce_appointment_cancelled', array( $this, 'remove_from_gcal' ) );

		// Process edited appointment.
		add_action( 'woocommerce_appointment_process_meta', array( $this, 'sync_edited_appointment' ) );

		// Sync trashed/untrashed appointments.
		add_action( 'trashed_post', array( $this, 'remove_from_gcal' ) );
		add_action( 'untrashed_post', array( $this, 'sync_untrashed_appointment' ) );

		// Active logs.
		if ( class_exists( 'WC_Logger' ) ) {
			$this->log = new WC_Logger();
		} else {
			$this->log = WC()->logger();
		}
	}

	/**
	 * Set redirect_uri option.
	 */
	public function set_redirect_uri( $option ) {
        $this->redirect_uri = $option;
    }

	/**
	 * Get redirect_uri option.
	 */
    public function get_redirect_uri() {
        return $this->redirect_uri;
    }

	/**
	 * Set callback_uri option.
	 */
	public function set_callback_uri( $option ) {
        $this->callback_uri = $option;
    }

	/**
	 * Get callback_uri option.
	 */
    public function get_callback_uri() {
        return $this->callback_uri;
    }

	/**
	 * Set client_id option.
	 */
	public function set_client_id( $option ) {
        $this->client_id = $option;
    }

	/**
	 * Get client_id option.
	 */
    public function get_client_id() {
        return $this->client_id;
    }

	/**
	 * Set client_secret option.
	 */
	public function set_client_secret( $option ) {
        $this->client_secret = $option;
    }

	/**
	 * Get client_secret option.
	 */
    public function get_client_secret() {
        return $this->client_secret;
    }

	/**
	 * Set calendar_id option.
	 */
	public function set_calendar_id( $option ) {
        $this->calendar_id = $option;
    }

	/**
	 * Get calendar_id option.
	 */
    public function get_calendar_id() {
        return $this->calendar_id;
    }

	/**
	 * Set user_id option.
	 */
	public function set_user_id( $option ) {
        $this->user_id = $option;
		$calendar_id   = get_user_meta( $option, 'wc_appointments_gcal_calendar_id', true );
		$calendar_id   = $calendar_id ? $calendar_id : $this->get_calendar_id();

		$this->set_calendar_id( $calendar_id );
    }

	/**
	 * Get user_id option.
	 */
    public function get_user_id() {
        return $this->user_id;
    }

	/**
	 * Set debug option.
	 */
	public function set_debug( $option ) {
        $this->debug = $option;
    }

	/**
	 * Get debug option.
	 */
    public function get_debug() {
        return $this->debug;
    }

	/**
	 * Set twoway option.
	 */
	public function set_twoway( $option ) {
        $this->twoway = $option;
    }

	/**
	 * Get twoway option.
	 */
    public function get_twoway() {
        return $this->twoway;
    }

	/**
	 * Get twoway option.
	 */
    public function is_twoway_enabled() {
		$twoway_enabled = ( 'no' === $this->get_twoway() ) ? false : true;

        return $twoway_enabled;
    }

	/**
	 * Display admin screen notices.
	 *
	 * @return string
	 */
	public function admin_notices() {
		$screen = get_current_screen();

		$allowed_screens = array( 'user-edit', 'woocommerce_page_wc-settings' );

		if ( in_array( $screen->id, $allowed_screens ) && isset( $_GET['wc_gcal_oauth'] ) ) {
			if ( 'success' == $_GET['wc_gcal_oauth'] ) {
				echo '<div class="updated fade"><p><strong>' . __( 'Google Calendar', 'woocommerce-appointments' ) . '</strong> ' . __( 'Account connected successfully!', 'woocommerce-appointments' ) . '</p></div>';
			} else {
				echo '<div class="error fade"><p><strong>' . __( 'Google Calendar', 'woocommerce-appointments' ) . '</strong> ' . __( 'Failed to connect to your account, please try again, if the problem persists, turn on Debug Log option and see what is happening.', 'woocommerce-appointments' ) . '</p></div>';
			}
		}

		if ( in_array( $screen->id, $allowed_screens ) && isset( $_GET['wc_gcal_logout'] ) ) {
			if ( 'success' == $_GET['wc_gcal_logout'] ) {
				echo '<div class="updated fade"><p><strong>' . __( 'Google Calendar', 'woocommerce-appointments' ) . '</strong> ' . __( 'Account disconnected successfully!', 'woocommerce-appointments' ) . '</p></div>';
			} else {
				echo '<div class="error fade"><p><strong>' . __( 'Google Calendar', 'woocommerce-appointments' ) . '</strong> ' . __( 'Failed to disconnect to your account, please try again, if the problem persists, turn on Debug Log option and see what is happening.', 'woocommerce-appointments' ) . '</p></div>';
			}
		}
	}

	/**
	 * Get Access Token.
	 *
	 * @param  string $code Authorization code.
	 *
	 * @return string       Access token.
	 */
	public function get_access_token( $code = '', $user_id = '' ) {
		$user_id = $user_id ? $user_id : '';
		$user_id = $this->get_user_id() ? $this->get_user_id() : $user_id;
		
		wcfm_log( "Here:: 1" );

		// Check roles if user is shop staff.
		if ( $user_id ) {
			$user_meta = get_userdata( $user_id );
			if ( isset( $user_meta->roles ) && ! in_array( 'shop_staff', (array) $user_meta->roles ) && ! in_array( 'wcfm_vendor', (array) $user_meta->roles ) && ! in_array( 'dc_vendor', (array) $user_meta->roles ) && ! in_array( 'seller', (array) $user_meta->roles ) && ! in_array( 'vendor', (array) $user_meta->roles ) ) {
				return;
			}
		}
		
		wcfm_log( "Here:: 2" );

		// Get access token.
		if ( $user_id ) {
			$access_token = get_transient( 'wc_appointments_gcal_access_token_' . $user_id );
		} else {
			$access_token = get_transient( 'wc_appointments_gcal_access_token' );
		}

		// Get refresh token.
		if ( $user_id ) {
			$refresh_token = get_user_meta( $user_id, 'wc_appointments_gcal_refresh_token', true );
		} else {
			$refresh_token = get_option( 'wc_appointments_gcal_refresh_token' );
		}

		if ( ! $code && $refresh_token ) {
			$data = array(
				'client_id'     => $this->get_client_id(),
				'client_secret' => $this->get_client_secret(),
				'refresh_token' => $refresh_token,
				'grant_type'    => 'refresh_token',
			);

			$params = array(
				'body'      => http_build_query( $data ),
				'sslverify' => false,
				'timeout'   => 60,
				'headers'   => array(
					'Content-Type' => 'application/x-www-form-urlencoded',
				),
			);

			$response = wp_remote_post( $this->oauth_uri . 'token', $params );

			if ( ! is_wp_error( $response ) && 200 == $response['response']['code'] && 'OK' == $response['response']['message'] ) {
				$response_data = json_decode( $response['body'] );
				$access_token  = sanitize_text_field( $response_data->access_token );

				// Set the transient.
				if ( $user_id ) {
					set_transient( 'wc_appointments_gcal_access_token_' . $user_id, $access_token, 3500 );
					if ( 'yes' === $this->get_debug() ) {
						#$this->log->add( $this->id, 'Google API Access Token for staff #' . $user_id . ' generated successfully: ' . $access_token ); #debug
					}
				} else {
					set_transient( 'wc_appointments_gcal_access_token', $access_token, 3500 );
					if ( 'yes' === $this->get_debug() ) {
						#$this->log->add( $this->id, 'Google API Access Token generated successfully: ' . $access_token ); #debug
					}
				}

				return $access_token;
			} else {
				if ( 'yes' === $this->get_debug() ) {
					#$this->log->add( $this->id, 'Error while generating the Access Token: ' . var_export( $response['response'], true ) ); #debug
				}
			}
		} elseif ( '' !== $code ) {
			if ( 'yes' === $this->get_debug() ) {
				#$this->log->add( $this->id, 'Renewing the Access Token...' ); #debug
			}

			$data = array(
				'code'          => $code,
				'client_id'     => $this->get_client_id(),
				'client_secret' => $this->get_client_secret(),
				'redirect_uri'  => $this->get_redirect_uri(),
				'grant_type'    => 'authorization_code',
			);

			$params = array(
				'body'      => http_build_query( $data ),
				'sslverify' => false,
				'timeout'   => 60,
				'headers'   => array(
					'Content-Type' => 'application/x-www-form-urlencoded',
				),
			);

			$response = wp_remote_post( $this->oauth_uri . 'token', $params );

			if ( ! is_wp_error( $response ) && 200 == $response['response']['code'] && 'OK' == $response['response']['message'] ) {
				$response_data = json_decode( $response['body'] );
				$access_token  = sanitize_text_field( $response_data->access_token );

				// Add refresh token.
				if ( $user_id ) {
					update_user_meta( $user_id, 'wc_appointments_gcal_refresh_token', $response_data->refresh_token );
				} else {
					update_option( 'wc_appointments_gcal_refresh_token', $response_data->refresh_token );
				}

				// Set the transient.
				if ( $user_id ) {
					set_transient( 'wc_appointments_gcal_access_token_' . $user_id, $access_token, 3500 );
					if ( 'yes' === $this->get_debug() ) {
						#$this->log->add( $this->id, 'Google API Access Token for staff #' . $user_id . ' renewed successfully: ' . $access_token ); #debug
					}
				} else {
					set_transient( 'wc_appointments_gcal_access_token', $access_token, 3500 );
					if ( 'yes' === $this->get_debug() ) {
						#$this->log->add( $this->id, 'Google API Access Token renewed successfully: ' . $access_token ); #debug
					}
				}

				return $access_token;
			} else {
				if ( 'yes' === $this->get_debug() ) {
					#$this->log->add( $this->id, 'Error while renewing the Access Token: ' . var_export( $response['response'], true ) ); #debug
				}
			}
		}

		if ( 'yes' === $this->get_debug() ) {
			#$this->log->add( $this->id, 'Failed to retrieve and generate the Access Token. Code: ' . $code . ', User: ' . $user_id . ', Refresh token: ' . $refresh_token ); #debug
		}
	}

	/**
	 * OAuth Logout.
	 *
	 * @return bool
	 */
	protected function oauth_logout( $user_id = '' ) {
		$user_id = $user_id ? $user_id : '';
		$user_id = $this->get_user_id() ? $this->get_user_id() : $user_id;

		if ( 'yes' === $this->get_debug() ) {
			$this->log->add( $this->id, 'Disconnecting from the Google Calendar app...' ); #debug
		}

		// Get the refresh token.
		$refresh_token = $user_id ? get_user_meta( $user_id, 'wc_appointments_gcal_refresh_token', true ) : get_option( 'wc_appointments_gcal_refresh_token' );

		if ( $refresh_token ) {
			$params = array(
				'sslverify' => false,
				'timeout'   => 60,
				'headers'   => array(
					'Content-Type' => 'application/x-www-form-urlencoded',
				),
			);

			$response = wp_remote_get( $this->oauth_uri . 'revoke?token=' . $refresh_token, $params );

			if ( ! is_wp_error( $response ) && 200 == $response['response']['code'] && 'OK' == $response['response']['message'] ) {
				// Delete tokens.
				if ( $user_id ) {
					delete_user_meta( $user_id, 'wc_appointments_gcal_channel_id' );
					delete_user_meta( $user_id, '_wc_appointments_gcal_callback_resourceid' );
					delete_user_meta( $user_id, 'wc_appointments_gcal_refresh_token' );
					delete_transient( 'wc_appointments_gcal_access_token_' . $user_id );
				} else {
					delete_option( 'wc_appointments_gcal_channel_id' );
					delete_option( '_wc_appointments_gcal_callback_resourceid' );
					delete_option( 'wc_appointments_gcal_refresh_token' );
					delete_transient( 'wc_appointments_gcal_access_token' );
				}

				if ( 'yes' === $this->get_debug() ) {
					$this->log->add( $this->id, 'Successfully disconnected from the Google Calendar app' ); #debug
				}

				return true;
			} else {
				if ( 'yes' === $this->get_debug() ) {
					$this->log->add( $this->id, 'Error while disconnecting from the Google Calendar app: ' . var_export( $response['response'], true ) ); #debug
				}
			}
		}

		if ( 'yes' === $this->get_debug() ) {
			$this->log->add( $this->id, 'Failed to disconnect from the Google Calendar app' ); #debug
		}

		return false;
	}

	/**
	 * Process the oauth redirect.
	 *
	 * @return void
	 */
	public function oauth_redirect() {
		if ( ! current_user_can( 'manage_appointments' ) ) {
			wp_die( __( 'Permission denied!', 'woocommerce-appointments' ) );
		}

		// User ID passed.
		if ( isset( $_GET['state'] ) ) {

			$user_id       = absint( $_GET['state'] );
			$admin_url     = admin_url( 'user-edit.php' );
			$redirect_args = array(
				'user_id' => $_GET['state'],
			);

		} else {

			$user_id       = '';
			$admin_url     = admin_url( 'admin.php' );
			$redirect_args = array(
				'page'    => 'wc-settings',
				'tab'     => 'appointments',
				'section' => $this->id,
			);

		}

		// OAuth.
		if ( isset( $_GET['code'] ) ) {
			$code         = sanitize_text_field( $_GET['code'] );
			$access_token = $this->get_access_token( $code, $user_id );

			if ( ! $access_token ) {
				$redirect_args['wc_gcal_oauth'] = 'fail';

				wp_redirect( add_query_arg( $redirect_args, $admin_url ), 301 );
				exit;
			} else {
				$redirect_args['wc_gcal_oauth'] = 'success';

				wp_redirect( add_query_arg( $redirect_args, $admin_url ), 301 );
				exit;
			}
		}

		// Error.
		if ( isset( $_GET['error'] ) ) {
			$redirect_args['wc_gcal_oauth'] = 'fail';

			wp_redirect( add_query_arg( $redirect_args, $admin_url ), 301 );
			exit;
		}

		// Logout.
		if ( isset( $_GET['logout'] ) ) {
			$logout                          = $this->oauth_logout( $user_id );
			$redirect_args['wc_gcal_logout'] = ( $logout ) ? 'success' : 'fail';

			wp_redirect( add_query_arg( $redirect_args, $admin_url ), 301 );
			exit;
		}

		wp_die( __( 'Invalid request!', 'woocommerce-appointments' ) );
	}

	/**
	 * Get user calendars.
	 *
	 * @return array Calendar list
	 */
	public function get_user_calendars() {
		// Get all Google Calendars.
		$google_calendars = array();

		// Check if Authorized.
		$access_token = $this->get_access_token();
		if ( ! $access_token ) {
			return;
		}

		// Connection params.
		$params = array(
			'method'    => 'GET',
			'sslverify' => false,
			'timeout'   => 60,
			'headers'   => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bearer ' . $access_token,
			),
		);

		$response = wp_remote_post( 'https://www.googleapis.com/calendar/v3/users/me/calendarList', $params );

		if ( ! is_wp_error( $response ) && 200 == $response['response']['code'] && 'OK' == $response['response']['message'] ) {
			// Get response data.
			$response_data = json_decode( $response['body'], true );

			// List calendars.
			if ( is_array( $response_data['items'] ) && ! empty( $response_data['items'] ) ) {
				foreach ( $response_data['items'] as $data ) {
					$google_calendars[ $data['id'] ] = $data['summary'];
				}
			}
		}

		return $google_calendars;
	}

	/**
	 * Sync new Appointment with GCal.
	 *
	 * @param  int $appointment_id Appointment ID
	 * @return void
	 */
	public function sync_new_appointment( $appointment_id ) {
		if ( $this->is_edited_from_meta_box() ) {
			return;
		}

		$this->maybe_sync_to_gcal_from_status( $appointment_id );
	}

	/**
	 * Check if Google Calendar settings are supplied.
	 *
	 * @return bool True is calendar is set, false otherwise.
	 */
	public function is_calendar_set() {
		$client_id     = $this->get_client_id();
		$client_secret = $this->get_client_secret();
		$calendar_id   = $this->get_calendar_id();

		return ! empty( $client_id ) && ! empty( $client_secret ) && ! empty( $calendar_id );
	}

	/**
	 * Makes an http request to the Google Calendar API.
	 *
	 * @param  string $api_url API Url to make the request against
	 * @param  array  $params  Array of parameters that will be used when making the request
	 * @version       3.5.6
	 * @since         3.5.6
	 * @return object Response object from the request
	 */
	protected function make_gcal_request( $api_url, $params = array(), $staff_id = '' ) {
		if ( ! isset( $api_url ) ) {
			return false;
		}

		// Check if Authorized.
		$access_token = $this->get_access_token( '', $staff_id );
		if ( ! $access_token ) {
			return;
		}

		// Connection params.
		$params['method']    = ( isset( $params['method'] ) ) ? strtoupper( $params['method'] ) : 'GET';
		$params['sslverify'] = false;
		$params['timeout']   = 60;
		$params['headers']   = array(
			'Content-Type'  => 'application/json',
			'Authorization' => 'Bearer ' . $access_token,
		);

		if ( isset( $params['querystring'] ) && is_array( $params['querystring'] ) ) {
			$api_url .= '?' . http_build_query( wp_json_encode( $params['querystring'], JSON_UNESCAPED_SLASHES ) );
		}

		if ( 'GET' === $params['method'] ) {
			unset( $params['body'] );
		}

		// Filter the gCal request.
		$params = apply_filters( 'woocommerce_appointments_gcal_sync_parameters', $params, $api_url, $staff_id );

		$response = wp_remote_request( $api_url, $params );

		if ( ! is_wp_error( $response ) && 200 == $response['response']['code'] && 'OK' == $response['response']['message'] ) {
			if ( 'yes' === $this->get_debug() ) {
				$this->log->add( $this->id, 'Google calendar request successful!' );
			}
		} elseif ( 'yes' === $this->get_debug() ) {
			$this->log->add( $this->id, 'Error while making Google Calendar request for ' . $api_url . ': ' . var_export( $response['response'], true ) ); #debug
		}

		return $response;
	}

	/**
	 * Sync an event resource with Google Calendar.
	 * https://developers.google.com/google-apps/calendar/v3/reference/events
	 *
	 * @param   int            $appointment_id Appointment ID
	 * @param   array          $params Set of parameters to be passed to the http request
	 * @param   array          $data Optional set of data for writeable syncs
	 * @since                  3.5.6
	 * @version                3.5.6
	 * @return  object|boolean Parsed JSON data from the http request or false if error
	 */
	public function sync_event_resource( $appointment_id = -1, $params = array(), $resource_params = array(), $data = array() ) {
		if ( $appointment_id < 0 ) {
			return false;
		}

		$appointment = get_wc_appointment( $appointment_id );
		$event_id    = $resource_params['event_id'];
		$staff_id    = $resource_params['staff_id'];
		$calendar_id = $resource_params['calendar_id'];
		$api_url     = $this->calendars_uri . $calendar_id . '/events' . ( ( $event_id ) ? '/' . $event_id : '' );
		$json_data   = false;

		if ( isset( $params['method'] ) && 'GET' !== $params['method'] ) {
			$params['body'] = wp_json_encode( apply_filters( 'woocommerce_appointments_gcal_sync', $data, $appointment ) );
		}

		try {

			if ( 'yes' === $this->get_debug() ) {
				$this->log->add( $this->id, 'Synchronizing appointment #' . $appointment->get_id() . ' with Google Calenda: ' . $calendar_id ); #debug
			}

			$response  = $this->make_gcal_request( $api_url, $params, $staff_id );
			$json_data = json_decode( $response['body'], true );

		} catch ( Exception $e ) {
			$json_data = false;

			if ( 'yes' === $this->get_debug() ) {
				$this->log->add( $this->id, 'Error while getting data for ' . $api_url . ': ' . print_r( $response, true ) ); #debug
			}
		}

		return $json_data;

	}

	/**
	 * Sync Appointment to GCal
	 *
	 * @param  int $appointment_id Appointment ID
	 * @return void
	 */
	public function sync_to_gcal( $appointment_id, $appointment_staff_id = false, $staff_calendar_id = false ) {
		$is_calendar_set = $this->is_calendar_set();
		if ( ! $is_calendar_set || 'wc_appointment' !== get_post_type( $appointment_id ) ) {
			return;
		}

		/**
		 * woocommerce_appointments_sync_to_gcal_start hook
		 */
		do_action( 'woocommerce_appointments_sync_to_gcal_start', $appointment_id, $appointment_staff_id );

		$appointment = get_wc_appointment( $appointment_id );
		$staff_ids   = $appointment->get_staff_ids();
		if ( $appointment_staff_id ) {
			$staff_event_ids = $appointment->get_google_calendar_staff_event_ids();
			$event_id        = isset( $staff_event_ids[ $appointment_staff_id ] ) ? $staff_event_ids[ $appointment_staff_id ] : '';
		} else {
			$event_id = $appointment->get_google_calendar_event_id();
		}
		$product    = $appointment->get_product();
		$product_id = $appointment->get_product_id();
		$order      = $appointment->get_order();
		$customer   = $appointment->get_customer();
		$timezone   = wc_appointment_get_timezone_string();
		/* translators: 1: appointment ID */
		$summary                     = sprintf( __( 'Appointment #%s', 'woocommerce-appointments' ), $appointment_id ) . ( $product ? ' - ' . html_entity_decode( $product->get_title() ) : '' );
		$description                 = '';
		$description_does_exist      = false;
		$description_has_been_edited = false;

		// Add customer name.
		if ( $customer && $customer->name ) {
			$description .= sprintf( '%s: %s', __( 'Customer', 'woocommerce-appointments' ), $customer->name ) . PHP_EOL;
		} else {
			$description .= sprintf( '%s: %s', __( 'Customer', 'woocommerce-appointments' ), __( 'Guest', 'woocommerce-appointments' ) ) . PHP_EOL;
		}

		// Product name.
		if ( is_object( $product ) ) {
			$description .= sprintf( '%s: %s', __( 'Product', 'woocommerce-appointments' ), $product->get_title() ) . PHP_EOL;
		}

		// Appointment data.
		$appointment_data = array(
			__( 'Appointment ID', 'woocommerce-appointments' ) => $appointment_id,
			__( 'When', 'woocommerce-appointments' )      => $appointment->get_start_date(),
			__( 'Duration', 'woocommerce-appointments' )  => $appointment->get_duration(),
			__( 'Providers', 'woocommerce-appointments' ) => $appointment->get_staff_members( true ),
		);

		foreach ( $appointment_data as $key => $value ) {
			if ( empty( $value ) ) {
				continue;
			}

			$description .= sprintf( '%1$s: %2$s', rawurldecode( html_entity_decode( $key ) ), rawurldecode( html_entity_decode( $value ) ) ) . PHP_EOL;
		}

		// Addons and other order items.
		if ( is_a( $order, 'WC_Order' ) ) {
			foreach ( $order->get_items() as $order_item ) {
				foreach ( $order_item->get_meta_data() as $order_meta_data ) {
					$the_meta_data = $order_meta_data->get_data();
					if ( is_serialized( $the_meta_data['value'] ) ) {
						continue;
					}
					if ( is_array( $the_meta_data['key'] ) ) {
						continue;
					}
					if ( is_array( $the_meta_data['value'] ) && ! empty( $the_meta_data['value'] ) ) {
						$the_meta_data['value'] = implode( ', ', $the_meta_data['value'] );
					}
					// Fix for WooCommerce TM Extra Product Options plugin.
					if ( '_tmcartepo_data' === $the_meta_data['key'] || '_tm_epo_product_original_price' === $the_meta_data['key'] || '_tm_epo' === $the_meta_data['key'] ) {
						continue;
					}

					$description .= sprintf( '%s: %s', rawurldecode( html_entity_decode( $the_meta_data['key'] ) ), rawurldecode( html_entity_decode( $the_meta_data['value'] ) ) ) . PHP_EOL;
				}
			}
		}

		// Resource params.
		$resource_params = array(
			'event_id'    => $event_id,
			'staff_id'    => $appointment_staff_id,
			'calendar_id' => ( $staff_calendar_id ? $staff_calendar_id : $this->get_calendar_id() ),
		);

		// Update event.
		if ( $event_id ) {
			$response_data = $this->sync_event_resource(
				$appointment_id,
				array(
					'method'      => 'GET',
					'querystring' => array(
						'fields' => 'summary, description',
					),
				),
				$resource_params
			);

			$description_does_exist      = isset( $response_data['description'] ) && ( '' !== trim( $response_data['description'] ) );
			$description_has_been_edited = isset( $response_data['description'] ) && $response_data['description'] !== $description;

			// If the user edited the description on the Google Calendar side we want to keep that data intact.
			if ( $description_does_exist && $description_has_been_edited ) {
				$description = $response_data['description'];
			}

			$summary_does_exist      = isset( $response_data['summary'] ) && ( '' !== trim( $response_data['summary'] ) );
			$summary_has_been_edited = isset( $response_data['summary'] ) && $response_data['summary'] !== $summary;

			// If the user edited the summary (event title) on the Google Calendar side we want to keep that data intact.
			if ( $summary_does_exist && $summary_has_been_edited ) {
				$summary = $response_data['summary'];
			}
		}

		// Set the event data.
		$data = array(
			'summary'     => wp_kses_post( $summary ),
			'description' => wp_kses_post( $description ),
		);

		// Set the event start and end dates.
		if ( $appointment->is_all_day() ) {
			$data['end'] = array(
				'date' => date( 'Y-m-d', ( $appointment->get_end() + 1440 ) ),
			);

			$data['start'] = array(
				'date' => date( 'Y-m-d', $appointment->get_start() ),
			);
		} else {
			$data['end'] = array(
				'dateTime' => date( 'Y-m-d\TH:i:s', $appointment->get_end() ),
				'timeZone' => $timezone,
			);

			$data['start'] = array(
				'dateTime' => date( 'Y-m-d\TH:i:s', $appointment->get_start() ),
				'timeZone' => $timezone,
			);
		}

		$response_data = $this->sync_event_resource(
			$appointment_id,
			array(
				'method' => ( $event_id ) ? 'PUT' : 'POST',
			),
			$resource_params,
			$data
		);

		// Save event ID only when available.
		if ( isset( $response_data['id'] ) ) {
			if ( $appointment_staff_id ) {
				$appointment->set_google_calendar_staff_event_ids( array( $appointment_staff_id => $response_data['id'] ) );
			} else {
				$appointment->set_google_calendar_event_id( wc_clean( $response_data['id'] ) );
			}
		}

		// Save appointment also calls $appointment->status_transition() in which
		// infinite loop could happens.
		$appointment->skip_status_transition_events();
		$appointment->save();

		// Sync for each staff.
		// Only when $appointment_staff_id is false,
		// so it does not go into inifinite loop.
		if ( $staff_ids && ! $appointment_staff_id ) {
			$count_staff = 0;
			foreach ( $staff_ids as $staff_id ) {
				$calendar_id       = get_user_meta( $staff_id, 'wc_appointments_gcal_calendar_id', true );
				$staff_calendar_id = $calendar_id ? $calendar_id : '';
				// Staff must have calendar ID set.
				if ( $staff_calendar_id ) {
					$this->sync_to_gcal( $appointment_id, $staff_id, $staff_calendar_id );
					$count_staff++;
				}
			}

			/*
			// Don't delete event ID's from removed staff
			// in case you add it back in future.
			if ( ! $count_staff ) {
				$appointment->set_google_calendar_staff_event_ids('');
				$appointment->save();
			}
			*/
		}
	}

	/**
	 * Read GCal callbacks in live 2-way sync
	 *
	 * @return void
	 */
	public function sync_callback() {
		// Stop here if calendar is not set.
		$is_calendar_set = $this->is_calendar_set();
		if ( ! $is_calendar_set ) {
			return;
		}

		// Check if Authorized.
		$access_token = $this->get_access_token();
		if ( ! $access_token ) {
			return;
		}

		// Stop here if callback error
		// has already been checked in past 1 day.
		$transient_callback_error = 'schedule_sync_' . md5( http_build_query( array( '_wc_appointments_gcal_callback_error', WC_Cache_Helper::get_transient_version( 'appointments' ) ) ) );

		if ( $this->get_user_id() ) {
			$error_token = get_transient( $transient_callback_error . '_' . $this->get_user_id() );
		} else {
			$error_token = get_transient( $transient_callback_error );
		}

		// If callback ID's exist, abort.
		if ( $error_token ) {
			return;
		}

		// Get the Channel ID, so
		// live sync doesn't get into a loop.
		if ( $this->get_user_id() ) {
			$channel_id = get_user_meta( $this->get_user_id(), 'wc_appointments_gcal_channel_id', true );
		} else {
			$channel_id = get_option( 'wc_appointments_gcal_channel_id' );
		}

		// If callback ID's exist, abort.
		if ( $channel_id ) {
			return;
		}

		// Random ID.
		$generate_rand_id = wp_generate_password( 12, false );

		// Create callback ID if it doesn't exist yet.
		$data = array(
			'id'      => $generate_rand_id,
			'type'    => 'web_hook',
			'address' => $this->get_callback_uri(),
		);

		// Pass user ID to live sync channel.
		if ( $this->get_user_id() ) {
			$data['token'] = $this->get_user_id();
		}

		// Connection params.
		$params = array(
			'method'    => 'POST',
			'body'      => wp_json_encode( $data, JSON_UNESCAPED_SLASHES ),
			'sslverify' => false,
			'timeout'   => 60,
			'headers'   => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bearer ' . $access_token,
			),
		);

		// Send site callback uri, where calendars
		// will be watched for live updates.
		$response = wp_remote_post( $this->calendars_uri . $this->get_calendar_id() . '/events/watch', $params );

		// Get response data.
		$response_data = json_decode( $response['body'], true );

		if ( is_wp_error( $response ) || 200 !== $response['response']['code'] || 'OK' !== $response['response']['message'] ) {
			if ( 'yes' === $this->get_debug() ) {
				$this->log->add( $this->id, 'Error while sending callback URI for live sync: ' . var_export( $response_data['error'], true ) ); #debug
			}

			// Only check for callback error once a day.
			if ( $this->get_user_id() ) {
				delete_user_meta( $this->get_user_id(), 'wc_appointments_gcal_channel_id' );
				set_transient( $transient_callback_error . '_' . $this->get_user_id(), true, DAY_IN_SECONDS );
			} else {
				delete_option( 'wc_appointments_gcal_channel_id' );
				set_transient( $transient_callback_error, true, DAY_IN_SECONDS );
			}
		} else {
			if ( 'yes' === $this->get_debug() ) {
				$this->log->add( $this->id, 'Sending callback URI for live sync sucessful: ' . var_export( $response['response'], true ) ); #debug
			}

			// Update the Channel ID and Callback ID, so
			// live sync doesn't get into a loop.
			if ( $this->get_user_id() ) {
				update_user_meta( $this->get_user_id(), 'wc_appointments_gcal_channel_id', $generate_rand_id );
				update_user_meta( $this->get_user_id(), '_wc_appointments_gcal_callback_resourceid', $response_data['resourceId'] );
			} else {
				update_option( 'wc_appointments_gcal_channel_id', $generate_rand_id );
				update_option( '_wc_appointments_gcal_callback_resourceid', $response_data['resourceId'] );
			}
		}
	}

	/**
	 * Is edited from post.php's meta box.
	 *
	 * @return bool
	 */
	public function is_edited_from_meta_box() {
		return (
			! empty( $_POST['wc_appointments_details_meta_box_nonce'] )
			&&
			wp_verify_nonce( $_POST['wc_appointments_details_meta_box_nonce'], 'wc_appointments_details_meta_box' )
		);
	}

	/**
	 * Sync Appointment with GCal when appointment is edited.
	 *
	 * @param  int $appointment_id Appointment ID
	 * @return void
	 */
	public function sync_edited_appointment( $appointment_id ) {
		if ( ! $this->is_edited_from_meta_box() ) {
			return;
		}

		$this->maybe_sync_to_gcal_from_status( $appointment_id );
	}

	/**
	 * Sync Appointment with GCal when appointment is untrashed.
	 *
	 * @param  int $appointment_id Appointment ID
	 *
	 * @return void
	 */
	public function sync_untrashed_appointment( $appointment_id ) {
		$this->maybe_sync_to_gcal_from_status( $appointment_id );
	}

	/**
	 * Maybe remove / sync appointment based on appointment status.
	 *
	 * @param int $appointment_id Appointment ID
	 * @return void
	 */
	public function maybe_sync_to_gcal_from_status( $appointment_id ) {
		global $wpdb;

		$status = $wpdb->get_var( $wpdb->prepare( "SELECT post_status FROM $wpdb->posts WHERE post_type = 'wc_appointment' AND ID = %d", $appointment_id ) );

		if ( 'cancelled' === $status ) {
			$this->remove_from_gcal( $appointment_id );
		} elseif ( in_array( $status, apply_filters( 'woocommerce_appointments_gcal_sync_statuses', array( 'confirmed', 'paid', 'complete' ) ) ) ) {
			$this->sync_to_gcal( $appointment_id );
		}
	}

	/**
	 * Remove/cancel the appointment in GCal
	 *
	 * @param  int $appointment_id Appointment ID
	 * @return void
	 */
	public function remove_from_gcal( $appointment_id, $appointment_staff_id = false, $staff_calendar_id = false ) {
		$appointment = get_wc_appointment( $appointment_id );
		if ( ! $appointment ) {
			return;
		}
		$staff_ids = $appointment->get_staff_ids();

		if ( $appointment_staff_id ) {
			$staff_event_ids = $appointment->get_google_calendar_staff_event_ids();
			$event_id        = isset( $staff_event_ids[ $appointment_staff_id ] ) ? $staff_event_ids[ $appointment_staff_id ] : '';
		} else {
			$event_id = $appointment->get_google_calendar_event_id();
		}

		// Check if Authorized.
		$access_token = $this->get_access_token( '', $appointment_staff_id );
		if ( ! $access_token ) {
			return;
		}

		// Calendar ID.
		$calendar_id = $staff_calendar_id ? $staff_calendar_id : $this->get_calendar_id();

		// Stop here if calendar is not set.
		if ( ! $calendar_id ) {
			return;
		}

		// Remove event.
		if ( $event_id ) {
			$api_url = $this->calendars_uri . $calendar_id . '/events/' . $event_id;

			// Connection params.
			$params = array(
				'method'    => 'DELETE',
				'sslverify' => false,
				'timeout'   => 60,
				'headers'   => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bearer ' . $access_token,
				),
			);

			if ( 'yes' === $this->get_debug() ) {
				$this->log->add( $this->id, 'Removing appointment #' . $appointment_id . ' from Google Calendar: ' . $calendar_id );
			}

			$response = wp_remote_post( $api_url, $params );

			if ( ! is_wp_error( $response ) && 204 == $response['response']['code'] ) {
				if ( 'yes' === $this->get_debug() ) {
					$this->log->add( $this->id, 'Event #' . $event_id . ' removed successfully!' );
				}
			} else {
				if ( 'yes' === $this->get_debug() ) {
					$this->log->add( $this->id, 'Error while removing event #' . $event_id . ': from Google Calendar: ' . $calendar_id . ' : ' . var_export( $response['response'], true ) );
				}
			}

			// Sync for each staff.
			// Only when $appointment_staff_id is false,
			// so it does not go into inifinite loop.
			if ( $staff_ids && ! $appointment_staff_id ) {
				$count_staff = 0;
				foreach ( $staff_ids as $staff_id ) {
					$staff_calendar_id = ( $calendar_id = get_user_meta( $staff_id, 'wc_appointments_gcal_calendar_id', true ) ) ? $calendar_id : '';
					// Staff must have calendar ID set.
					if ( $staff_calendar_id ) {
						$this->remove_from_gcal( $appointment_id, $staff_id, $staff_calendar_id );
						$count_staff++;
					}
				}
			}
		}
	}

	/**
	 * Process the live sycn callback.
	 *
	 * Read max 250 records at one time.
	 *
	 * @return void
	 */
	public function callback_read() {
		// Leave if callback not registered.
		if ( ! isset( $_SERVER['HTTP_X_GOOG_RESOURCE_ID'] ) ) {
			return;
		}

		// Get saved user ID.
		if ( isset( $_SERVER['HTTP_X_GOOG_RESOURCE_ID'] ) ) {
			$user_args = array(
				'meta_key'    => '_wc_appointments_gcal_callback_resourceid',
				'meta_value'  => $_SERVER['HTTP_X_GOOG_RESOURCE_ID'],
				'number'      => 1,
				'count_total' => false,
			);
			$user      = get_users( $user_args );
			if ( isset( $user[0]->ID ) && $user[0]->ID ) {
				$this->set_user_id( absint( $user[0]->ID ) );
			}
		}

		// Get channel token.
		if ( $this->get_user_id() ) {
			$channel_token = get_user_meta( $this->get_user_id(), 'wc_appointments_gcal_channel_id', true );
		} else {
			$channel_token = get_option( 'wc_appointments_gcal_channel_id' );
		}

		// Stop here if tokens missmatch.
		if ( isset( $_SERVER['HTTP_X_GOOG_CHANNEL_ID'] ) && $channel_token && $channel_token !== $_SERVER['HTTP_X_GOOG_CHANNEL_ID'] ) {
			return;
		}

		// Check if Authorized.
		$access_token = $this->get_access_token();
		if ( ! $access_token ) {
			return;
		}

		// Connection params.
		$params = array(
			'method'    => 'GET',
			'sslverify' => false,
			'timeout'   => 60,
			'headers'   => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bearer ' . $access_token,
			),
		);

		// Don't sync events older than now.
		$timeMin = new DateTime();
		$timeMin->setTimezone( new DateTimeZone( wc_appointment_get_timezone_string() ) );
		$timeMin = $timeMin->format( \DateTime::RFC3339 );
		$timeMin = rawurlencode( $timeMin );

		// Don't sync events more than 1 year in future.
		$timeMax = new DateTime();
		$timeMax->setTimezone( new DateTimeZone( wc_appointment_get_timezone_string() ) );
		$timeMax->modify( '+1 year' );
		$timeMax = $timeMax->format( \DateTime::RFC3339 );
		$timeMax = rawurlencode( $timeMax );

		// Perform a full synchronization without any syncToken.
		// singleEvents - return single instance of each recurring event.
		// maxResults - 250 by default.
		$response = wp_remote_post( $_SERVER['HTTP_X_GOOG_RESOURCE_URI'] . "&singleEvents=true&timeMin=$timeMin&timeMax=$timeMax", $params );

		// Response error.
		if ( is_wp_error( $response ) || 200 !== $response['response']['code'] || 'OK' !== strtoupper( $response['response']['message'] ) ) {
			if ( 'yes' === $this->get_debug() ) {
				$this->log->add( $this->id, 'Error while performing live sync from Google Calendar: ' . var_export( $response['response']['message'], true ) );
			}
			return;
		}

		// Fetch the events.
		$this->gcal_fetch_events( $response );
	}

	/**
	 * Sync back events from GCal.
	 *
	 * @return void
	 */
	public function sync_from_gcal( $user_id = '' ) {
		// If $user_id is passed fill in user variable.
		if ( $user_id ) {
			$this->set_user_id( $user_id );
		}

		// Stop here if calendar is not set.
		$is_calendar_set = $this->is_calendar_set();
		if ( ! $is_calendar_set ) {
			return;
		}

		// Check if Authorized.
		$access_token = $this->get_access_token();
		if ( ! $access_token ) {
			return;
		}

		// Connection params.
		$params = array(
			'method'    => 'GET',
			'sslverify' => false,
			'timeout'   => 60,
			'headers'   => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bearer ' . $access_token,
			),
		);

		// Don't sync events older than now.
		$timeMin = new DateTime();
		$timeMin->setTimezone( new DateTimeZone( wc_appointment_get_timezone_string() ) );
		$timeMin = $timeMin->format( \DateTime::RFC3339 );
		$timeMin = rawurlencode( $timeMin );

		// Don't sync events more than 1 year in future.
		$timeMax = new DateTime();
		$timeMax->setTimezone( new DateTimeZone( wc_appointment_get_timezone_string() ) );
		$timeMax->modify( '+1 year' );
		$timeMax = $timeMax->format( \DateTime::RFC3339 );
		$timeMax = rawurlencode( $timeMax );

		// Perform a full synchronization without any syncToken.
		// singleEvents - return single instance of each recurring event.
		// maxResults - 250 by default.
		$response = wp_remote_post( $this->calendars_uri . $this->get_calendar_id() . '/events' . "?singleEvents=true&timeMin=$timeMin&timeMax=$timeMax", $params );

		// Fetch the events.
		$this->gcal_fetch_events( $response );

		// Send GCal callback uri for live sync.
		// Could only be sent once, but sending each time
		// sync is performed.
		$this->sync_callback();
	}

	/**
	 * Fetch the events and generate gcal availability.
	 *
	 * @param  array  $global_availability   Availability rules.
	 * @return void
	 */
	public function gcal_fetch_events( $response ) {
		// Stop here if no $response.
		if ( ! $response ) {
			return;
		}

		// Get gcals availability rules.
		$gcal_availability_rules = $this->gcal_availability_rules( $response );

		// Stop here if no availability rules.
		if ( ! $gcal_availability_rules ) {
			if ( $this->get_user_id() ) {
				delete_user_meta( $this->get_user_id(), 'wc_appointments_gcal_availability' );
				delete_user_meta( $this->get_user_id(), 'wc_appointments_gcal_availability_last_synced' );
			} else {
				delete_option( 'wc_appointments_gcal_availability' );
				delete_option( 'wc_appointments_gcal_availability_last_synced' );
			}

			return;
		}

		// Last synced variables.
		// 0: current time in timestamp.
		// 1: number of events synced.
		$last_synced[] = absint( current_time( 'timestamp' ) );
		$last_synced[] = absint( count( $gcal_availability_rules ) );

		// Save gcal availability.
		if ( $this->get_user_id() ) {
			update_user_meta( $this->get_user_id(), 'wc_appointments_gcal_availability', $gcal_availability_rules );
			update_user_meta( $this->get_user_id(), 'wc_appointments_gcal_availability_last_synced', $last_synced );
		} else {
			update_option( 'wc_appointments_gcal_availability', $gcal_availability_rules );
			update_option( 'wc_appointments_gcal_availability_last_synced', $last_synced );
		}
	}

	/**
	 * Generate availability rules from GCal.
	 *
	 * @param  array $response
	 * @return void
	 */
	public function gcal_availability_rules( $response ) {
		// Response error.
		if ( is_wp_error( $response ) || 200 !== $response['response']['code'] || 'OK' !== strtoupper( $response['response']['message'] ) ) {
			if ( 'yes' === $this->get_debug() ) {
				$this->log->add( $this->id, 'Error while performing sync from Google Calendar: ' . $this->get_calendar_id() . ': ' . var_export( $response['response'], true ) );
			}
			return;
		}

		// Hook: woocommerce_appointments_sync_from_gcal_start
		do_action( 'woocommerce_appointments_sync_from_gcal_start', $response );

		// Get site TimeZone.
		$wp_appointments_timezone = wc_appointment_get_timezone_string();

		// Get response data.
		$response_data = json_decode( $response['body'], true );

		// No events.
		if ( empty( $response_data['items'] ) || ! is_array( $response_data['items'] ) ) {
			return;
		}

		// Define new availabiliy.
		$gcal_availability = array();

		#update_option( 'xxx3', $response_data );

		// Assemble events
		foreach ( $response_data['items'] as $event ) {
			// Check if event is already synced
			// with existing appointment.
			$args = array(
				'meta_query'             => array(
					'relation' => 'OR',
					array(
						'key'   => '_wc_appointments_gcal_event_id',
						'value' => $event['id'],
					),
					array(
						'key'     => '_wc_appointments_gcal_staff_event_ids',
						'value'   => $event['id'],
						'compare' => 'LIKE',
					),
				),
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'post_type'              => 'wc_appointment',
				'posts_per_page'         => '1',
			);

			$get_appointments_uids = new WP_Query();
			$appointments_uids     = $get_appointments_uids->query( $args );
			$appointment_uid       = isset( $appointments_uids[0]->ID ) ? absint( $appointments_uids[0]->ID ) : '';

			// Update existing appointment data.
			if ( $appointment_uid ) {
				// When event is deleted inside GCal set appointment status to cancelled and go to next event.
				if ( isset( $event['status'] ) && 'CANCELLED' === strtoupper( $event['status'] ) ) {
					// Update appointment status to cancelled.
					$appointment = get_wc_appointment( $appointment_uid );
					$appointment->update_status( 'cancelled' );
					$appointment->save();

					// Go to next event.
					continue;
				}
			}

			// Go to next event rent has status
			// other than CONFIRMED.
			if ( isset( $event['status'] ) && 'CONFIRMED' !== strtoupper( $event['status'] ) ) {
				continue;
			}

			// Check if all day event.
			// value = DATE for all day, otherwise time included.
			$all_day = isset( $event['start']['date'] ) && isset( $event['end']['date'] ) ? true : false;

			// Check if BUSY or FREE.
			// value = OPAQUE for busy, and TRANSPARENT for free
			#$yes_no = isset( $event['transparency'] ) && 'TRANSPARENT' === strtoupper( $event['transparency'] ) ? 'yes' : 'no';
			$yes_no = 'no';

			if ( $all_day ) {
				// Get Start and end date information
				$dtstart = new DateTime( $event['start']['date'] );
				$dtend   = new DateTime( $event['end']['date'] );

				// Reduce 1 sec from end date.
				$dtend->modify( '-1 second' );

				// Define new custom date rule
				$new_rule = array(
				    'type'        => 'custom', // rule type used for this example
				    'appointable' => $yes_no,
				    'priority'    => 5,
				    'from'        => $dtstart->format( 'Y-m-d' ),
				    'to'          => $dtend->format( 'Y-m-d' ),
				);
			} else {
				// Get Start and end datetime information
				$dtstart = new DateTime( $event['start']['dateTime'] );
				$dtstart->setTimezone( new DateTimeZone( $wp_appointments_timezone ) );
				$dtend = new DateTime( $event['end']['dateTime'] );
				$dtend->setTimezone( new DateTimeZone( $wp_appointments_timezone ) );

				// Define new time:range rule
				$new_rule = array(
				    'type'        => 'time:range', // rule type used for this example
				    'appointable' => $yes_no,
				    'priority'    => 5,
				    'from'        => $dtstart->format( 'H:i' ),
				    'to'          => $dtend->format( 'H:i' ),
				    'from_date'   => $dtstart->format( 'Y-m-d' ),
				    'to_date'     => $dtend->format( 'Y-m-d' ),
				);
			}

			// Go to next if current event is already synced
			// with existing appointment.
			if ( $appointment_uid ) {

				// Prepare meta for updating.
				$meta_args = apply_filters(
					'wc_appointments_gcal_sync_order_itemmeta',
					array(
						'_appointment_start'   => $dtstart->format( 'YmdHis' ),
						'_appointment_end'     => $dtend->format( 'YmdHis' ),
						'_appointment_all_day' => intval( $all_day ),
					),
					$appointment_uid,
					$event
				);

				// Apply update from GCal.
				foreach ( $meta_args as $key => $value ) {
					update_post_meta( $appointment_uid, $key, $value );
				}

				// Debug.
				if ( 'yes' === $this->debug ) {
					if ( $this->get_user_id() ) {
						$this->log->add( $this->id, 'Successfully updated appointment #' . $appointment_uid . ' from Google Calendar event #' . $event['id'] . ' for staff #' . $this->get_user_id() );
					} else {
						$this->log->add( $this->id, 'Successfully updated appointment #' . $appointment_uid . ' from Google Calendar event #' . $event['id'] );
					}
				}

				// Go to next event
				// when this one is updated.
				continue;
			}

			// Pass the new rule.
			$gcal_availability[] = apply_filters( 'woocommerce_appointments_gcal_sync_rule', $new_rule, $event );
		}

		#update_option( 'xxx4', $gcal_availability );

		if ( ! $gcal_availability ) {
			return;
		}

		if ( 'yes' === $this->get_debug() ) {
			if ( $this->get_user_id() ) {
				$this->log->add( $this->id, 'Sync from Google Calendar for staff #' . $this->get_user_id() . ' is successful.' ); #debug
			} else {
				$this->log->add( $this->id, 'Sync from Google Calendar is successful.' ); #debug
			}
		}

		// Availability rules.
		return $gcal_availability;
	}

	/**
	 * Filter global availability.
	 *
	 * @param  array  $global_availability   Availability rules.
	 * @return array  global availability rules.
	 */
	public function sync_global_availability( $global_availability ) {
		// Check if Authorized.
		$access_token = $this->get_access_token();
		if ( ! $access_token ) {
			return $global_availability;
		}

		// Get gcal availability rules.
		$gcal_availability = get_option( 'wc_appointments_gcal_availability' );

		// Return default availability.
		if ( ! $gcal_availability ) {
			return $global_availability;
		}

		// Merge .gcal rules with staff availability.
		$global_availability = array_filter(
			array_merge(
				$global_availability,
				$gcal_availability
			)
		);

		return $global_availability;
	}

	/**
	 * Filter staff availability.
	 *
	 * @param  array  $staff_availability   Availability rules.
	 * @param  object $staff                User object.
	 * @return array  Staff availability rules.
	 */
	public function sync_staff_availability( $staff_availability, $staff ) {
		// User object.
		if ( ! $staff ) {
			return $staff_availability;
		}

		// Check if Authorized.
		$access_token = $this->get_access_token( '', $staff->get_id() );
		if ( ! $access_token ) {
			return $staff_availability;
		}

		// Get gcal availability rules.
		$gcal_availability = get_user_meta( $staff->get_id(), 'wc_appointments_gcal_availability', true );
		$gcal_availability = $gcal_availability ? $gcal_availability : '';

		// Return default availability.
		if ( ! $gcal_availability ) {
			return $staff_availability;
		}

		// Merge .gcal rules with staff availability.
		$staff_availability = array_filter(
			array_merge(
				$staff_availability,
				$gcal_availability
			)
		);

		return $staff_availability;
	}
}

/**
 * Returns the main instance of WC_Appointments_Integration_GCal to prevent the need to use globals.
 *
 * @return WC_Appointments_Integration_GCal
 */
function wc_appointments_integration_gcal() {
	return WC_Appointments_Integration_GCal::instance();
}

add_action( 'init', 'integration_gcal' );
function integration_gcal() {
	return wc_appointments_integration_gcal();
}
