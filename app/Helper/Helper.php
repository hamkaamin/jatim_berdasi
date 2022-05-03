<?php

namespace App\Helper;

class Helper
{
	public static function getRole($role_id)
	{
		$role = "-";
		if ($role_id == 1) {
			$role = "Super Admin";
		} elseif ($role_id == 2) {
			$role = "Verifikator";
		} elseif ($role_id == 3) {
			$role = "Admin - Provinsi";
		} elseif ($role_id == 4) {
			$role = "Admin - Kab/Kota";
		} elseif ($role_id == 5) {
			$role = "OPD";
		} elseif ($role_id == 6) {
			$role = "Umum";
		}
		return $role;
	}
}

?>