<?php

namespace App\Helper;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Opd;
use Illuminate\Support\Facades\Auth;

class Helper
{
	public static function nvl($val1, $val2)
	{
		$res = $val1;
		if (empty($val1)) {
			$res = $val2;
		}
		return $res;
	}

	public static function getRole($role_id)
	{
		$role = "-";
		if ($role_id == 1) {
			$role = "Super Admin";
		} elseif ($role_id == 2) {
			$role = "Verifikator";
		} elseif ($role_id == 3) {
			$role = "Admin - Provinsi";
		} elseif ($role_id == 5) {
			$role = "Admin - Kab/Kota";
		} elseif ($role_id == 4) {
			$role = "OPD";
		} elseif ($role_id == 6) {
			$role = "Umum";
		} elseif ($role_id == 7) {
			$role = "Juri";
		}
		return $role;
	}

	public static function getKategoriRole($role_id)
	{
		if($role_id == 2){
			$id_kategori = [];
            if(Auth::user()->is_kategori_1 == 1){
                $id_kategori[] = 1;
            }if(Auth::user()->is_kategori_2 == 1){
                $id_kategori[] = 2;
            }
            if(Auth::user()->is_kategori_3 == 1){
                $id_kategori[] = 3;
            }
            if(Auth::user()->is_kategori_4 == 1){
                $id_kategori[] = 4;
            }
            if(Auth::user()->is_kategori_5 == 1){
                $id_kategori[] = 5;
            }
			
		}
		return $id_kategori;
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

	// public static function save_file($file, $name, $folder, $existing)
	// {
	// 	try {
	// 		if ($existing != null && file_exists(public_path('/'.$folder.'/'.$existing))) {
	// 			unlink(public_path('/'.$folder.'/'.$existing));
	// 		}
	// 		$nama_file = env('APP_URL').'/'.$folder.'/'.$name.'.'.$file->getClientOriginalExtension();
	// 		$file->move($folder, $nama_file);
	// 		return $nama_file;
	// 	} catch (\Throwable $th) {
	// 		// if(Auth::user()->username == 'balitbangda_kabupaten_bangkalan'){
	// 		// 	throw $th;
	// 		// }
	// 		$nama_file = "file_error";

	// 		return $nama_file;
	// 	}
	// }

	
	public static function save_file($file, $name, $folder, $existing, $allowedExtensions = [])
	{
		try {
			// Hapus file lama jika ada
			if ($existing && file_exists(public_path("$folder/$existing"))) {
				unlink(public_path("$folder/$existing"));
			}

			$extension = strtolower($file->getClientOriginalExtension());
			$mime = $file->getMimeType();

			if (!in_array($extension, $allowedExtensions)) {
				return [
					'valid' => false,
					'message' => "Ekstensi .{$extension} tidak diperbolehkan."
				];
			}

			$allowedMimes = self::get_mime_types($extension);

			if (!in_array($mime, $allowedMimes)) {
				return [
					'valid' => false,
					'message' => "Tipe File Upload {$mime} tidak valid. Allowed: " . implode(', ', $allowedMimes)
				];
			}

			if ($file->getSize() > 2 * 1024 * 1024) {
				return ['valid' => false, 'message' => 'Ukuran file melebihi batas maksimum 2MB.'];
			}

			try { 
				// Cek isi konten: tidak boleh mengandung kode PHP
				$content = file_get_contents($file->getRealPath());
				if (preg_match('/<\?php/i', $content)) {
					return ['valid' => false, 'message' => "Konten mengandung file PHP."];
				} 
			} catch (\Throwable $th) {
				//throw $th;
			}
			// Validasi isi file
			if ($extension === 'pdf') {
				$handle = fopen($file->getRealPath(), 'r');
				$firstLine = fgets($handle);
				fclose($handle);

				if (strpos($firstLine, '%PDF') !== 0) {
					return [
						'valid' => false,
						'message' => 'Isi file PDF tidak valid.'
					];
				}
			}

			if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
				if (!@getimagesize($file->getRealPath())) {
					return [
						'valid' => false,
						'message' => 'Isi file gambar tidak valid.'
					];
				}
			}

			// Simpan file
			$fileName = $name . '.' . $extension;
			$file->move(public_path($folder), $fileName);

			return [
				'valid' => true,
				'message' => 'File berhasil diunggah.',
				'file_name' =>  env('APP_URL').'/'.$folder.'/'.$fileName
			];

		} catch (\Throwable $th) {
			return 'file_error';
		}
	}

	public static function get_mime_types($file_mimes) {
		$mime_types = [];
		if($file_mimes == 'pdf') {
			$mime_types = ['application/pdf'];
		} elseif($file_mimes == 'xls') {
			$mime_types = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
		} elseif($file_mimes == 'doc') {
			$mime_types = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
		} elseif($file_mimes == 'zip') {
			$mime_types = ['application/zip', 'application/x-zip-compressed'];
		} elseif($file_mimes == 'jpg' || $file_mimes == 'jpeg' || $file_mimes == 'png') {
			$mime_types = ['image/jpeg', 'image/png'];
		}elseif($file_mimes == 'docx') {
			$mime_types = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
		} elseif($file_mimes == 'xlsx') {
			$mime_types = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
		} elseif($file_mimes == 'pptx') {
			$mime_types = ['application/vnd.openxmlformats-officedocument.presentationml.presentation'];
		} elseif($file_mimes == 'ppt') {
			$mime_types = ['application/vnd.ms-powerpoint'];
		} else {
			$mime_types = ['*/*'];
		}
		return $mime_types;
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
		} elseif ($id == 5) {
			$status = "<span class='badge badge-info'>Dikirim</span>";
		}
		return $status;
	}

	public static function getStatusKovablik($id)
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
		} elseif ($id == 5) {
			$status = "<span class='badge badge-info'>Dikirim</span>";
		}
		return $status;
	}

	public static function generateKolomUpload($indikator)
	{
		$kolom = [['Judul', 'judul', 'text', 1]];
		$tipe_file = explode(",", $indikator->tipe_file);
		if (count($tipe_file) == 1) {
			if ($tipe_file[0] == 'pdf') {
				$kolom[] = ['No. Dokumen', 'no_dokumen', 'text', 0];
				$kolom[] = ['Tgl. Dokumen', 'tgl_dokumen', 'date', 0];
			} elseif ($tipe_file[0] == 'mp4') {
				$kolom[] = ['Kover', 'cover', 'file', 0];
				$kolom[] = ['URL', 'url', 'url', 0];
			}
		} else {
			$kolom[] = ['Tentang', 'tentang', 'textarea', 1];
		}
		$kolom[] = ['File', 'file', 'file', 0];
		return $kolom;
	}

	public static function get_label_inovasi($id)
	{
		switch ($id) {
			case 0:
				return "Inovasi Daerah";
				break;
			case 1:
				return "Inotek Awards";
				break;
			case 2:
				return "Proposal Kovablik";
				break;
		}
	}

	public static function checkUserUmum($scope, $user)
	{
		if ($user->role == 6) {
			if ($scope == 'provinsi' && $user->province_id != null) {
				return true;
			} elseif ($scope == 'kota' && $user->regency_id != null) {
				return true;
			} elseif ($scope == 'opd-provinsi' && $user->opd_id != null && $user->opd->provinsi_id != null) {
				return true;
			} elseif ($scope == 'opd-kota' && $user->opd_id != null && $user->opd->kabkota_id != null) {
				return true;
			} elseif ($scope == 'opd-kecamatan' && $user->opd_id != null && $user->opd->kecamatan_id != null) {
				return true;
			} elseif ($scope == 'opd-kelurahan' && $user->opd_id != null && $user->opd->kelurahan_id != null) {
				return true;
			}
		}
		return false;
	}
}
