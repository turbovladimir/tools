<?php


namespace Tools\Assistant;


class StringAssistant
{
    public static function splitId($data, $split = ",|\n|\r\n?")
    {
        if (is_array($data)) {
            $clean_data = $data;
        } else {
            $clean_data = preg_split("#{$split}#", $data);
        }

        $clean_data = array_map('trim', $clean_data);
        $clean_data = array_unique($clean_data);
        $clean_data = array_filter($clean_data);
        $clean_data = array_values($clean_data);

        return $clean_data;
    }
}