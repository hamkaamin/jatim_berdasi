<?php

namespace App\Helper;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Opd;

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

	public static function getOpdProvinsi($idStart, $array)
	{
		$array = self::getOpd('provinsi', $idStart, $array);
		$temp = Kota::where('province_id', $idStart)->get();
		foreach ($temp as $kota) {
			$array = self::getOpd('kota', $kota->id, $array);
			$temp2 = Kecamatan::where('regency_id', $kota->id)->get();
			foreach ($temp2 as $kecamatan) {
				$array = self::getOpd('kecamatan', $kecamatan->id, $array);
				$temp3 = Kelurahan::where('district_id', $kecamatan->id)->get();
				foreach ($temp3 as $kelurahan) {
					$array = self::getOpd('kelurahan', $kelurahan->id, $array);
				}
			}
		}
		return $array;
	}

	public static function getOpdKota($idStart, $array)
	{
		$array = self::getOpd('kota', $idStart, $array);
		$temp2 = Kecamatan::where('regency_id', $idStart)->get();
		foreach ($temp2 as $kecamatan) {
			$array = self::getOpd('kecamatan', $kecamatan->id, $array);
			$temp3 = Kelurahan::where('district_id', $kecamatan->id)->get();
			foreach ($temp3 as $kelurahan) {
				$array = self::getOpd('kelurahan', $kelurahan->id, $array);
			}
		}
		return $array;
	}

	public static function getOpdKecamatan($idStart, $array)
	{
		$array = self::getOpd('kecamatan', $idStart, $array);
		$temp3 = Kelurahan::where('district_id', $idStart)->get();
		foreach ($temp3 as $kelurahan) {
			$array = self::getOpd('kelurahan', $kelurahan->id, $array);
		}
		return $array;
	}

	public static function getOpd($type, $idStart, $array)
	{
		$temp = [];
		if ($type == "provinsi") {
			$temp = Opd::where('provinsi_id', $idStart)->get();
		} elseif ($type == "kota") {
			$temp = Opd::where('kabkota_id', $idStart)->get();
		} elseif ($type == "kecamatan") {
			$temp = Opd::where('kecamatan_id', $idStart)->get();
		} elseif ($type == "kelurahan") {
			$temp = Opd::where('kelurahan_id', $idStart)->get();
		}
		foreach ($temp as $item) {
			$array[] = $item;
		}
		return $array;
	}

	public static function checkOpd($scope, $user)
	{
		if ($user->role == 5) {
			if ($scope == 'provinsi' && $user->opd->provinsi_id != null) {
				return true;
			} elseif ($scope == 'kota' && $user->opd->kabkota_id != null) {
				return true;
			} elseif ($scope == 'kecamatan' && $user->opd->kecamatan_id != null) {
				return true;
			} elseif ($scope == 'kelurahan' && $user->opd->kelurahan_id != null) {
				return true;
			}
		}
		return false;
	}

	public static function save_file($file, $name, $folder, $existing)
	{
		if ($existing != null && file_exists(public_path('/'.$folder.'/'.$existing))) {
			unlink(public_path('/'.$folder.'/'.$existing));
		}
		$nama_file = $name.'.'.$file->getClientOriginalExtension();
		$file->move($folder, $nama_file);
		return $nama_file;
	}

	public static function getStatusInovasi($id)
	{
		$status = "";
		if ($id == 0) {
			$status = "<span class='badge badge-secondary'>Draft</span>";
		} elseif ($id == 1) {
			$status = "<span class='badge badge-primary'>Diproses</span>";
		} elseif ($id == 2) {
			$status = "<span class='badge badge-success'>Disetujui</span>";
		} elseif ($id == 3) {
			$status = "<span class='badge badge-danger'>Ditolak</span>";
		} elseif ($id == 4) {
			$status = "<span class='badge badge-warning'>Revisi</span>";
		}
		return $status;
	}
}

?>