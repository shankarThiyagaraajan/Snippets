<?php

   /**
    * Simple Tracking Snippet for DHL.
    */
   public function DHL_Tracking($tracking_id)
    {
        if(!$tracking_id || is_null($tracking_id)) return false;
    
        $data = '<?xml version="1.0" encoding="ISO-8859-1" ?>';
        $data .= '<data appname="nol-public" password="anfang" request="get-status-for-public-user" language-code="de">';
        $data .= '  <data piece-code="'.$tracking_id.'"></data>';
        $data .= '</data>';

        // URL bauen und File hohlen
        $xml = simplexml_load_file(sprintf(
            'http://nolp.dhl.de/nextt-online-public/direct/nexttjlibpublicservlet?xml=%s', $data
        ));

        // FALSE, wenn Syntax oder HTTP Error
        if ($xml === false) return false;

        // Wandelt das SimpleXML Objekt in ein Array um
        foreach ($xml->data->data->attributes() as $key => $value) {
            $return[$key] = (string)$value;
        }
        return $return;
    }
