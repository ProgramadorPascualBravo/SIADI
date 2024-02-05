<?php
/*
  Plugin Name: Zonapagos
  Plugin URI: http://www.zonavirtual.com/
  Description: Pagos seguros con tarjetas débito (PSE) y tarjetas de crédito a través de <a href="http://www.zonavirtual.com/" target="_blank">Zonapagos</a>.
  Version: 2.0.0
  Author: ZonaVirtual S.A.
  Author URI: http://www.zonavirtual.com/

  License: GNU General Public License v3.0
  License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
define('ZONAPAGOS_DIR', plugin_dir_path(__FILE__));
define('ZONAPAGOS_URL', plugin_dir_url(__FILE__));

function zonapagos_wc_active() {
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        return true;
    } else {
        return false;
    }
}

add_action('plugins_loaded', 'woocommerce_zonapagos_init', 0);

function woocommerce_zonapagos_init() {
    if (!class_exists('WC_Payment_Gateway')) {
        return;
    }
    //Add the gateway to woocommerce
    add_filter('woocommerce_payment_gateways', 'add_zonapagos_gateway');

    function add_zonapagos_gateway($methods) {
        $methods[] = 'WC_Gateway_Zonapagos';

        return $methods;
    }

    class WC_Gateway_Zonapagos extends WC_Payment_Gateway {

        const ZONAPAGOS_VERIFICAR_SANDBOX = 'https://www.zonapagosdemo.com/WsVerificarPagoV4/VerificarPagos.asmx?wsdl';
        const ZONAPAGOS_VERIFICAR_LIVE = 'https://www.zonapagos.com/WsVerificarPagoV4/VerificarPagos.asmx?wsdl';
        const ZONAPAGOS_INICIAR_SANDBOX = 'https://www.zonapagosdemo.com/ws_inicio_pagov2/Zpagos.asmx?wsdl';
        const ZONAPAGOS_INICIAR_LIVE = 'https://www.zonapagos.com/ws_inicio_pagov2/Zpagos.asmx?wsdl';

        public function __construct() {
            $this->id = 'zonapagos';
            $this->icon = ZONAPAGOS_URL . '/zonapagos.png';
            $this->has_fields = false;
            $this->method_title = 'Zonapagos';
            $this->method_description = 'Pagos seguros con tarjetas débito (PSE) y tarjetas de crédito';
            // Load the form fields
            $this->init_form_fields();
            $this->init_settings();
            // Get setting values
            $this->enabled = $this->get_option('enabled');
            $this->title = $this->settings['title'];
            $this->description = $this->settings['description'];
            $this->t_ruta = $this->settings['t_ruta'];
            $this->cod_servicio = $this->settings['cod_servicio'];
            $this->int_id_comercio = $this->settings['int_id_comercio'];
            $this->clave = $this->settings['clave'];
            $this->str_usr_comercio = (string) $this->settings['str_usr_comercio'];
            $this->str_pwd_Comercio = $this->settings['str_pwd_Comercio'];
            $this->email = $this->settings['email'];
            $this->phone = $this->settings['phone'];
            $this->testmode = $this->get_option('testmode');
            // Hooks
            add_action('woocommerce_receipt_zonapagos', array($this, 'receipt_page'));
            add_action('woocommerce_update_options_payment_gateways_zonapagos', array($this, 'process_admin_options'));
            add_action('woocommerce_order_details_after_order_table', array($this, 'payment_details'));
            add_filter('woocommerce_my_account_my_orders_actions', array($this, 'order_links'), 10, 2);
            //add_action( 'woocommerce_api_wc_gateway_zonapagos', array( $this, 'check_zonapagos_response' ) );
            //add_action( 'woocommerce_thankyou', array( $this, 'check_zonapagos_response' ) );
            if (!$this->is_valid_for_use()) {
                $this->enabled = false;
            }
        }

        public function admin_options() {
                ?>
        <h3>Zonapagos</h3>
            <p>Pagos seguros con tarjetas débito (PSE) y tarjetas de crédito.</p>
            <?php if ($this->is_valid_for_use()) : ?>
        <table class="form-table"><?php $this->generate_settings_html(); ?></table>
            <?php else : ?>
        <div class="inline error"><p><strong><?php _e('Gateway Disabled', 'woocommerce'); ?></strong>: Current
            La moneda no es válida para este método de pago. Debe ser COP</p></div>
            <?php
                endif;
        }

        //Check if this gateway is enabled and available in the user's country
        function is_valid_for_use() {
            if (!in_array(get_woocommerce_currency(), array(
                'COP'
            ))
            ) {
                return false;
            }

            return true;
        }

        //Initialize Gateway Settings Form Fields
        function init_form_fields() {
            $this->form_fields = array(
                'enabled' => array(
                'title' => 'Habilitado/Deshabilitado',
                'type' => 'checkbox',
                'label' => 'Habilitar Zonapagos',
                'default' => 'yes'
        ),
            'title' => array(
                'title' => 'Título',
                'type' => 'text',
                'description' => 'Este el título que el usuario mira en el checkout de WordPress',
                'default' => 'Zonapagos',
                'desc_tip' => true
        ),
            'description' => array(
                'title' => 'Description',
                'type' => 'textarea',
                'description' => 'Esta es la descripción que el usuario mira en el checkout de WordPress',
                'default' => 'Pagos seguros con tarjetas débito (PSE) y tarjetas de crédito',
                'desc_tip' => true
        ),
            't_ruta' => array(
                'title' => 'Ruta en la cual se ubica el datafono',
                'type' => 'text',
                'description' => 'Debe escribirla en minuscula ej: t_ruta',
                'default' => 't_ruta',
                'desc_tip' => true
        ),
            'cod_servicio' => array(
                'title' => 'Código de servicio',
                'type' => 'text',
                'description' => 'Código de recaudos maticulado en PSE y configurado en Zonapagos.',
                'default' => '',
                'desc_tip' => true
        ),
            'int_id_comercio' => array(
                'title' => 'Identificador único del comercio',
                'type' => 'text',
                'description' => 'Número de identificacion asignado por Zonapagos',
                'default' => '',
                'desc_tip' => true
        ),
            'clave' => array(
                'title' => 'Clave inicio',
                'type' => 'text',
                'description' => 'Clave inicio asignada por Zonapagos',
                'default' => '',
                'desc_tip' => true
        ),
            'str_usr_comercio' => array(
                'title' => 'Usuario V4',
                'type' => 'text',
                'description' => 'Usuario generador del pago. Este valor es suministrado por ZonaPAGOS.',
                'default' => '',
                'desc_tip' => true
        ),
            'str_pwd_Comercio' => array(
                'title' => 'Contraseña V4',
                'type' => 'text',
                'description' => 'Clave asignada por Zonapagos para acceder a la pasarela de pago',
                'default' => '',
                'desc_tip' => true
        ),
            'email' => array(
                'title' => 'Email de contacto',
                'type' => 'text',
                'description' => 'Email de contacto para sus clientes (área de soporte)',
                'default' => '',
                'desc_tip' => true
        ),
            'phone' => array(
                'title' => 'Teléfono de contacto',
                'type' => 'text',
                'description' => 'Teléfono de contacto para sus clientes (área de soporte)',
                'default' => '',
                'desc_tip' => true
        ),
            'testmode' => array(
                'title' => 'Modo de pruebas Zonapagos',
                'label' => 'Activado Modo de pruebas',
                'type' => 'checkbox',
                'description' => 'Configura el método de pago en Modo de pruebas',
                'default' => 'no',
                'desc_tip' => true
        ),
        );
        }

        $seven_ter_coda_value = null;


        foreach ($order->meta_data as $meta) {
        if ($meta->key === '_seven_ter_coda') {
        $seven_ter_coda_value = $meta->value;
        break;
    }
}

    function get_zonapagos_args($order,$seven_ter_coda_value) {
        //Zonapagos Args
        $order_id = $order->get_id();
        $zonapagos_args = array(
            'id_tienda' => $this->int_id_comercio,
            'clave' => $this->clave,
            'total_con_iva' => $order->get_total(),
            'valor_iva' => $order->get_total_tax(),
            'id_pago' => $order_id,
            'descripcion_pago' => 'Pago orden No. ' . $order_id,
            // informacion del cliente
            'email' => $order->get_billing_email(),
            //'id_cliente' => $order->get_user_id(),
            //'id_cliente' => $this->documento,
            'id_cliente' => $seven_ter_coda_value,
            //'id_cliente' => $order->meta_data[9]->value,
            'tipo_id' => '7',
            'nombre_cliente' => $order->get_billing_first_name(),
            'apellido_cliente' => $order->get_billing_last_name(),
            'telefono_cliente' => $order->get_billing_phone(),
            'info_opcional1' => '',
            'info_opcional2' => '',
            'info_opcional3' => '',
            // tipo servicio en la pasarela
            'codigo_servicio_principal' => (string) $this->cod_servicio,
            'lista_codigos_servicio_multicredito' => null,
            'lista_nit_codigos_servicio_multicredito' => null,
            'lista_valores_con_iva' => null,
            'lista_valores_iva' => null,
            'total_codigos_servicio' => '0'
    );
        return $zonapagos_args;
    }

    /**
     * verificar pago
     * */
    function pago_ok($order) {
        global $woocommerce;
        $order_id = $order->get_id();

        if ('yes' == $this->testmode) {
            $service_url = self::ZONAPAGOS_VERIFICAR_SANDBOX;
        } else {
            $service_url = self::ZONAPAGOS_VERIFICAR_LIVE;
        }
        $client = new SoapClient($service_url);

        $params = array(
            'int_id_comercio' => $this->int_id_comercio,
            'str_usr_comercio' => $this->str_usr_comercio,
            'str_pwd_Comercio' => $this->str_pwd_Comercio,
            'str_id_pago' => $order_id,
            'int_no_pago' => -1,
            'int_error' => 0,
            'int_cantidad_pagos' => 0
    );
        $result = $client->__soapCall('verificar_pago_v4', array($params));
        $response = true;
        if ($result->verificar_pago_v4Result == 1) {
            $pagos = $result->int_cantidad_pagos;
            if ($pagos > 0) {
                $response = false;
            }
        } else {
            $response = false;
        }
        return $response;
    }

    function cus($order_id) {
        global $woocommerce;

        if ('yes' == $this->testmode) {
            $service_url = self::ZONAPAGOS_VERIFICAR_SANDBOX;
        } else {
            $service_url = self::ZONAPAGOS_VERIFICAR_LIVE;
        }
        $client = new SoapClient($service_url);

        $params = array(
            'int_id_comercio' => $this->int_id_comercio,
            'str_usr_comercio' => $this->str_usr_comercio,
            'str_pwd_Comercio' => $this->str_pwd_Comercio,
            'str_id_pago' => $order_id,
            'int_no_pago' => -1,
            'int_error' => 0,
            'int_cantidad_pagos' => 0
    );
        $result = $client->__soapCall('verificar_pago_v4', array($params));
        $cus = [];
        if ($result->verificar_pago_v4Result == 1) {
            $pagos = $result->int_cantidad_pagos;
            $transacciones = explode("| ; |", $result->str_res_pago);
            $transacciones_array = [];
            foreach ($transacciones as $transaccion) {
                $transaccion_array = explode(" | ", $transaccion);
                if (sizeof($transaccion_array) > 1)
                    array_push($transacciones_array, $transaccion_array);
            }

            foreach ($transacciones_array as $transaccion) {
                $estado_pago = $transaccion[1];
                $forma_pago = $transaccion[14];
                if($estado_pago == "999" && $forma_pago == "29") {
                    $cus[0] = $forma_pago;
                    $cus[1] = $transaccion[19];
                }
                if($estado_pago == "4001" && $forma_pago == "32") {
                    $cus[0] = $forma_pago;
                }
            }
        }
        return $cus;
    }

    //Generate the zonapagos button link
    function generate_zonapagos_form($order_id) {
        global $woocommerce;
        $order = new WC_Order($order_id);
        if ('yes' == $this->testmode) {
            $zonapagos_adr = self::ZONAPAGOS_VERIFICAR_SANDBOX;
        } else {
            $zonapagos_adr = self::ZONAPAGOS_VERIFICAR_LIVE;
        }
        $zonapagos_args = $this->get_zonapagos_args($order);
        $zonapagos_args_array = array();
        foreach ($zonapagos_args as $key => $value) {
            $zonapagos_args_array[] = '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" />';
        }
        wc_enqueue_js('
        $.blockUI({
            message: "Thank you for your order. We are now redirecting you to Zonapagos to make payment.",
            baseZ: 99999,
            overlayCSS: { background: "#fff", opacity: 0.6 },
            css: {
                padding:        "20px",
                zindex:         "9999999",
                textAlign:      "center",
                color:          "#555",
                border:         "3px solid #aaa",
                backgroundColor:"#fff",
                cursor:         "wait",
                lineHeight:     "24px",
            }
        });

        jQuery("#zonapagos_payment_form").submit();
        ');
        $html_form = '<form action="' . esc_url($zonapagos_adr) . '" method="post" id="zonapagos_payment_form">'
            . implode('', $zonapagos_args_array)
            . '<input type="submit" class="button" id="wc_submit_zonapagos_payment_form" value="' . __('Pay via Zonapagos', 'tech') . '" /> <a class="button cancel" href="' . $order->get_cancel_order_url() . '">' . __('Cancel order &amp; restore cart', 'tech') . '</a>'
            . '</form>';

        return $html_form;
    }

    function process_payment($order_id) {
        global $wpdb;
        global $woocommerce;
        $checkout_url = wc_get_checkout_url();
        $order = wc_get_order($order_id);
        //$customer = $order->get_user_id();
        $pedido_pendientes = $wpdb->get_row($wpdb->prepare("SELECT p.ID,p.post_status,pm.meta_value,pm3.meta_value from $wpdb->posts p LEFT JOIN $wpdb->postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_payment_method' LEFT JOIN $wpdb->postmeta pm3 ON p.id = pm3.post_id AND pm3.meta_key = '_billing_email' where p.post_status = 'wc-pending' AND pm.meta_value = 'ZonaPAGOS' AND pm3.meta_value = %s AND p.ID != %d LIMIT 1", $order->get_billing_email(), $order_id));
        if (!$pedido_pendientes) {
            $pago_ok = $this->pago_ok($order);
            if ($pago_ok) {
                if ($this->testmode == 'yes') {
                    $service_url = self::ZONAPAGOS_INICIAR_SANDBOX;
                } else {
                    $service_url = self::ZONAPAGOS_INICIAR_LIVE;
                }

                $client = new SoapClient($service_url);
                $ZonaPAGOS_args = $this->get_zonapagos_args($order);
                $result = $client->__soapCall('inicio_pagoV2', array($ZonaPAGOS_args));
                $identificador = $result->inicio_pagoV2Result;

                $redirectUrl = 'https://www.zonapagos.com/' . $this->t_ruta . '/pago.asp?estado_pago=iniciar_pago&identificador=' . $identificador;
                print($redirectUrl);
                // Reduce stock levels
                wc_reduce_stock_levels($order_id);

                // Remove cart
                WC()->cart->empty_cart();

                return array(
                    'result' => 'success',
                    'redirect' => $redirectUrl
            );
                exit;
            } else {
                $cus = $this->cus($order->get_id());
                if(sizeof($cus) == 0){
                    $message = 'En este momento su Número de Referencia o Factura (' . $pedido_pendientes->ID ." Este debe ser el documento ".$seven_ter_coda_value."Este es el que esta en la posciion del array".$order->meta_data[4]->value. ') presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidadfinanciera, por favor espere unos minutos y vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa. Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de atención al cliente ' . $this->phone . ' o enviar un correo electrónico a ' . $this->email . '.';
                } elseif($cus[0] == "32"){
                    $message = 'En este momento su Número de Referencia o Factura (' . $pedido_pendientes->ID ." Este debe ser el documento ".$seven_ter_coda_value  ."Este es el que esta en la posciion del array".$order->meta_data[4]->value. ') presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidadfinanciera, por favor espere unos minutos y vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa. Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de atención al cliente ' . $this->phone . ' o enviar un correo electrónico a ' . $this->email . '.';
                } elseif($cus[0] == "29"){
                    $message = 'En este momento su Número de Referencia o Factura (' . $pedido_pendientes->ID ." Este debe ser el documento ".$seven_ter_coda_value."Este es el que esta en la posciion del array".$order->meta_data[4]->value. ') presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidad financiera, por favor espere unos minutos y vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa. Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de atención al cliente ' . $this->phone . ' o enviar un correo electrónico a ' . $this->email . ' y preguntar por el estado de la transacción: ' . $cus[1] . '.';
                }

                wc_add_notice($message, $notice_type = 'notice');

                return array(
                    'result' => 'success',
                    'redirect' => $checkout_url
            );
                exit;
            }
        } else {
            $cus = $this->cus($pedido_pendientes->ID);
            if(sizeof($cus) == 0){
                $message = 'En este momento su Número de Referencia o Factura ('  . $pedido_pendientes->ID ." Este debe ser el documento ".$seven_ter_coda_value."Este es el que esta en la posciion del array".$order->meta_data[4]->value. ') presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidadfinanciera, por favor espere unos minutos y vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa. Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de atención al cliente ' . $this->phone . ' o enviar un correo electrónico a ' . $this->email . '.';
            } elseif($cus[0] == "32"){
                $message = 'En este momento su Número de Referencia o Factura ('  . $pedido_pendientes->ID ." Este debe ser el documento ".$seven_ter_coda_value ."Este es el que esta en la posciion del array".$order->meta_data[4]->value. ') presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidadfinanciera, por favor espere unos minutos y vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa. Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de atención al cliente ' . $this->phone . ' o enviar un correo electrónico a ' . $this->email . '.';
            } elseif($cus[0] == "29"){
                $message = 'En este momento su Número de Referencia o Factura (' . $pedido_pendientes->ID ." Este debe ser el documento ".$seven_ter_coda_value ."Este es el que esta en la posciion del array".$order->meta_data[4]->value. ') presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidad financiera, por favor espere unos minutos y vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa. Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de atención al cliente ' . $this->phone . ' o enviar un correo electrónico a ' . $this->email . ' y preguntar por el estado de la transacción: ' . $cus[1] . '.';
            }

            wc_add_notice($message, $notice_type = 'notice');
            return array(
                'result' => 'success',
                'redirect' => $checkout_url
        );
            exit;
        }
    }

    function receipt_page($order) {
        echo '<p>Thank you - your order is now pending payment. We are now redirecting you to Zonapagos to make payment.</p>';
        echo $this->generate_zonapagos_form($order);
    }

    function order_links($actions, $order) {
        if (get_post_meta($order->get_id(), '_payment_method', true) == 'zonapagos') {
            unset($actions['pay']);
            unset($actions['cancel']);
        }
        return $actions;
    }

    function payment_details($order) {

        $order_id = $order->get_id();
        if (get_post_meta($order_id, '_payment_method', true) == 'zonapagos') {
            $payment_details = "<h2>Detalles del pago</h2>";
            $payment_details .= "<table class=\"shop_table order_details\">";
            $payment_details .= "<thead>";
            $payment_details .= "<tr>";
            $payment_details .= "<th class=\"product-name\">Concepto</th>";
            $payment_details .= "<th class=\"product-total\">Descripción</th>";
            $payment_details .= "</tr>";
            $payment_details .= "</thead>";
            $payment_details .= "<tbody>";
            $payment_details .= "<tr>";
            $payment_details .= "<td scope=\"row\">Identificación del pago:</td>";
            $payment_details .= "<td class=\"product-total\">" . $order_id . "</td>";
            $payment_details .= "</tr>";
            $payment_details .= "<tr>";
            $payment_details .= "<td scope=\"row\">Medio de pago:</td>";
            $payment_details .= "<td class=\"product-total\">" . (( $value = get_post_meta($order_id, '_zp_forma_pago', true) ) ? $value : 'No disponible. Intente mas tarde.') . "</td>";
            $payment_details .= "</tr>";
            $payment_details .= "<tr>";
            $payment_details .= "<td scope=\"row\">Estado en curso del pago:</td>";
            $payment_details .= "<td class=\"product-total\">" . (( $value = get_post_meta($order_id, '_zp_detalle_estado', true) ) ? $value : 'No disponible. Intente mas tarde.') . "</td>";
            $payment_details .= "</tr>";
            if(get_post_meta($order_id, '_zp_id_forma_pago', true) == "29"){
                $payment_details .= "<tr>";
                $payment_details .= "<td scope=\"row\">Banco:</td>";
                $payment_details .= "<td class=\"product-total\">" . (( $value = get_post_meta($order_id, '_zp_nombre_banco', true) ) ? $value : 'No disponible. Intente mas tarde.') . "</td>";
                $payment_details .= "</tr>";
                $payment_details .= "<tr>";
                $payment_details .= "<td scope=\"row\">Código único de seguimiento de la transacción en PSE (CUS):</td>";
                $payment_details .= "<td class=\"product-total\">" . (( $value = get_post_meta($order_id, '_zp_codigo_transaccion', true) ) ? $value : 'No disponible. Intente mas tarde.') . "</td>";
                $payment_details .= "</tr>";
            } elseif(get_post_meta($order_id, '_zp_id_forma_pago', true) == "32"){
                $payment_details .= "<tr>";
                $payment_details .= "<td scope=\"row\">Franquicia:</td>";
                $payment_details .= "<td class=\"product-total\">" . (( $value = get_post_meta($order_id, '_zp_franquicia', true) ) ? $value : 'No disponible. Intente mas tarde.') . "</td>";
                $payment_details .= "</tr>";
                $payment_details .= "<tr>";
                $payment_details .= "<td scope=\"row\">Número de tarjeta:</td>";
                $payment_details .= "<td class=\"product-total\">" . (( $value = '*' . get_post_meta($order_id, '_zp_num_tarjeta', true) ) ? $value : 'No disponible. Intente mas tarde.') . "</td>";
                $payment_details .= "</tr>";
                $payment_details .= "<tr>";
                $payment_details .= "<td scope=\"row\">Código de recibo de la transacción:</td>";
                $payment_details .= "<td class=\"product-total\">" . (( $value = '*' . get_post_meta($order_id, '_zp_num_recibo', true) ) ? $value : 'No disponible. Intente mas tarde.') . "</td>";
                $payment_details .= "</tr>";
            }
            $payment_details .= "</tbody>";
            $payment_details .= "</table>";
            echo $payment_details;
        }
    }

}

}

