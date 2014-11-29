<?php

use Illuminate\Support\Facades\Response;
class GlobalHelper {
    /**
     * This function will be used to spit out the variable dump.
     * It takes two parameters, one is the array / variable
     * and the second is flag for exit.
     * @param  array  $var  [array or variable]
     * @param  boolean $exit [should continue or exit]
     * @return none
     */
    public static function dsm($var, $exit = false)
    {
        print '<pre>';
        print_r($var);
        print '</pre>';
        $debug=debug_backtrace();
        echo "<br/> file :".$debug[0]['file'].", line :".$debug[0]['line'];
        if ($exit ===  true)
            exit;
    }
    
    /**
     * This function will set the message in session so that when the page renders,
     * we can display a message on top of the page.
     * @param $message
     * @param string $flag
     */
    public static function setMessage($message, $flag = 'error')
    {
        $tempMessage = '';
        if (Session::get('error'))
            $tempMessage = Session::get('error');
    
        if ($tempMessage == "")
            $tempMessage = $message;
        else
            $tempMessage = $tempMessage . '<br />' . $message;
    
        Session::flash($flag, $tempMessage);
    }
    
    /**
     * This is a generic function to generate a drop down from an array.
     * @param unknown $name
     * @param unknown $array
     * @param string $selected
     * @return string
     */
    public static function getDropdownFromArray($name, $array, $selected = null)
    {
        $output = "<select name=\"{$name}\" class=\"form-control\">";
        
        $output .= "<option value=\"\">SELECT</option>";
        
        foreach ($array as $key => $value) {
            if ($selected != null && $selected == $key) {
                $output .= "<option value=\"{$key}\" selected>{$value}</option>";
            } else {
                $output .= "<option value=\"{$key}\">{$value}</option>";
            }
        }
        
        $output .= "</select>";
        
        return $output;
    }
    
    public static function formatDate($dateString, $format)
    {
        $time = strtotime($dateString);
        return date($format, $time);
    }
    
    /**
     * Convert a string to the file/URL safe "slug" form
     *
     * @param string $string the string to clean
     * @param bool $is_filename TRUE will allow additional filename characters
     * @return string
     */
    public static function sanitize($string = '', $is_filename = FALSE)
    {
        // Replace all weird characters with dashes
        $string = preg_replace('/[^\w\-'. ($is_filename ? '~_\.' : ''). ']+/u', '-', $string);
    
        // Only allow one dash separator at a time (and make string lowercase)
        return mb_strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
    }
    /**
     * This function will take a time stamp and calculate time ago.
     *
     * @param $time_ago
     * @return string
     */
    public static function timeAgo($time_ago)
    {
        $cur_time 	= time();
        $time_elapsed 	= $cur_time - $time_ago;
        $seconds 	= $time_elapsed ;
        $minutes 	= round($time_elapsed / 60 );
        $hours 		= round($time_elapsed / 3600);
        $days 		= round($time_elapsed / 86400 );
        $weeks 		= round($time_elapsed / 604800);
        $months 	= round($time_elapsed / 2600640 );
        $years 		= round($time_elapsed / 31207680 );
        $result = "";
        // Seconds
        if($seconds <= 60)
        {
            $result = "$seconds seconds ago";
        }
        //Minutes
        else if($minutes <=60)
        {
            if($minutes==1)
                $result = "one minute ago";
            else
                $result = "$minutes minutes ago";
        }
        //Hours
        else if($hours <=24)
        {
            if($hours==1)
                $result = "an hour ago";
            else
                $result = "$hours hours ago";
        }
        //Days
        else if($days <= 7)
        {
            if($days==1)
                $result = "yesterday";
            else
                $result = "$days days ago";
        }
        //Weeks
        else if($weeks <= 4.3)
        {
            if($weeks==1)
                $result = "a week ago";
            else
                $result = "$weeks weeks ago";
        }
        //Months
        else if($months <=12)
        {
            if($months==1)
                $result = "a month ago";
            else
                $result = "$months months ago";
        }
        //Years
        else
        {
            if($years==1)
                $result = "one year ago";
            else
                $result = "$years years ago";
        }
        return $result;
    }

    public static function last_query() {
        $queries = DB::getQueryLog();
        return $last_query = end($queries);
    }

    public function print_last_query() {
        $this->dsm($this->last_query());
    }

    public static function convertStringToHTML($string)
    {
        $specialChars = array(
            ">" => "&gt;",
            "<" => "&lt;",
        );
        foreach ($specialChars as $char => $code) {
            $string = str_replace($char, $code, $string);
        }
        return $string;
    }

    function convertToCSV($data, $options)
    {

        // setting the csv header
        if (is_array($options) && isset($options['headers']) && is_array($options['headers'])) {
            $headers = $options['headers'];
        } 
        else {
            $filename=date('d-M').".csv";
            $headers = array(
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"'
            );
        }

        $output = '';

        // setting the first row of the csv if provided in options array
        if (isset($options['firstRow']) && is_array($options['firstRow'])) {
            $output .= implode(',', $options['firstRow']);
            $output .= "\n"; // new line after the first line
        }

        // setting the columns for the csv. if columns provided, then fetching the or else object keys
        if (isset($options['columns']) && is_array($options['columns'])) {
            $columns = $options['columns'];
        }
        else {
            $objectKeys = get_object_vars($data[0]);
            $columns = array_keys($objectKeys);
        }

        // populating the main output string
        foreach ($data as $row) {
            foreach ($columns as $column) {
                $output .= str_replace(',', ';', $row->$column);
                $output .= ',';
            }
            $output .= "\n";
        }

        // calling the Response class make function inside my class to send the response.
        // if our class is not a controller, this is required.
        return Response::make($output, 200, $headers);
    }
}