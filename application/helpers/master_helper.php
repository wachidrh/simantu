<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('last_id')) {
    function last_id($table, $column)
    {
        $CI = &get_instance();
        $CI->db->select_max($column);
        $CI->db->from($table);
        $data = $CI->db->get();
        $hasil = $data->row_array();
        return $hasil[$column] + 1;
    }
}

if (!function_exists('oracle_time')) {
    function oracle_time($timestamp)
    {
        $dateTime = DateTime::createFromFormat('d-M-y h.i.s.u A', $timestamp);
        $formattedTimestamp = $dateTime->format('Y-m-d H:i:s');
        return $formattedTimestamp;
    }
}

if (!function_exists('format_time')) {
    function format_time($timestamp)
    {
        $dateTimeObject = new DateTime($timestamp);
        $formattedDateTime = $dateTimeObject->format('d-m-Y H:i');
        return $formattedDateTime;
    }
}

if (!function_exists('relative_time')) {
    function relative_time($timestamp)
    {
        $givenDate = new DateTime($timestamp);

        $currentDate = new DateTime();
        $interval = $currentDate->diff($givenDate);

        $years = $interval->y;
        $months = $interval->m;
        $days = $interval->d;
        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;

        if ($years > 0) {
            $timeAgo = $years == 1 ? "1 tahun yang lalu" : "$years tahun yang lalu";
        } elseif ($months > 0) {
            $timeAgo = $months == 1 ? "1 bulan yang lalu" : "$months yang lalu";
        } elseif ($days > 0) {
            $timeAgo = $days == 1 ? "1 hari yang lalu" : "$days hari yang lalu";
        } elseif ($hours > 0) {
            $timeAgo = $hours == 1 ? "1 jam yang lalu" : "$hours jam yang lalu";
        } elseif ($minutes > 0) {
            $timeAgo = $minutes == 1 ? "1 menit yang lalu" : "$minutes menit yang lalu";
        } elseif ($seconds > 0) {
            $timeAgo = $seconds == 1 ? "1 detik yang lalu" : "$seconds detik yang lalu";
        } else {
            $timeAgo = "Baru saja";
        }

        return $timeAgo;
    }
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($money)
    {
        if (strpos($money, '.') === false) {
            return 'Rp. ' . number_format($money, 0, ",", ".");
        } else {
            return 'Rp. ' . number_format($money, 2, ",", ".");
        }
    }
}

if (!function_exists('get_weeks')) {
	function get_weeks($date)
	{
		if ($date == null) {
			return;
		}
		
		$timestamp = strtotime($date);

		// Calculate day of the month
		$day_of_month = (int)date('d', $timestamp);

		// Calculate custom week number
		$custom_week_number = (int)(($day_of_month - 1) / 7) + 1;

		return $custom_week_number;
	}
}

if (!function_exists('dd')) {
	/**
	 * Dump and die - Laravel style.
	 *
	 * @param mixed $data
	 */
	function dd($data)
	{
		echo '<div style="background-color: #f8f8f8; padding: 10px; border: 1px solid #ccc; margin: 10px;">';
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
		echo '</div>';
		die();
	}
}
