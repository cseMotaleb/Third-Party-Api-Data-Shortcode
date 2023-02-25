<?php
/**
 * Third Party Api Data Shortcode
 *
 * @package           PluginPackage
 * @author            Motaleb Hossain
 * @copyright         2023 Personal
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Third Party Api Data Shortcode
 * Plugin URI:        https://motaleb.info/tpads
 * Description:       Description of the plugin. [get_data_api]
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Motaleb Hossain
 * Author URI:        https://motaleb.info
 * Text Domain:       tpads
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://motaleb.info/tpads
 */

 defined('ABSPATH') || exit;

 add_shortcode('get_data_api', 'callback_funcation_name');

 function callback_funcation_name($atts){
    if( is_admin() ) {
        return '<p>This is where the shortcode [get_data_api] </p>';
    }
    $defaults = [
        'title' => 'Table Title'
    ];

    $atts = shortcode_atts(
        $defaults,
        $atts,
        'get_data_api'

    );

    $url = 'https://jsonplaceholder.typicode.com/users';
    $arguments = array(
        'method' => 'GET'
    );

    $response = wp_remote_get ($url, $arguments);
    if( is_wp_error ($response) ){
        $error_message = $response->get_error_message();
        return "Something went wrong: $error_message";
    }
    $results = json_decode( wp_remote_retrieve_body($response) );

    $html = '<h2>' . $atts['title'] . '<h2>
    <table>
        <tr>
            <td> ID </td>
            <td> Name </td>
            <td> Username </td>
            <td> Email </td>
            <td> Phone </td>
            <td> Address </td>
        </tr>';
    

    foreach( $results as $result){
        $html .= '<tr>';
        $html .= '<td>' . $result->id . '<td>';
        $html .= '<td>' . $result->name . '<td>';
        $html .= '<td>' . $result->username . '<td>';
        $html .= '<td>' . $result->Email . '<td>';
        $html .= '<td>' . $result->phone . '<td>';
        $html .= '<td>'  .  $result->address->street  .  ', ' . $result ->address->suite .  ', '  .  $result->address->city .  ', ' . $result->address->zipcode . '</td>';
     
        $html .= '<tr>';
    }

    $html .= '</table>';

    return $html;

 }