delete from indikator_inovasi where inovasi_id in (select id from inovasis where kota_id =3526)
delete from uploads where inovasi_id in (select id from inovasis where kota_id =3526)
delete from urusan_inovasi where inovasi_id in (select id from inovasis where kota_id =3526)
delete from tahapan_inovasi where inovasi_id in (select id from inovasis where kota_id =3526)
delete from inovasis where kota_id = 3526
delete from users where role = 4 and regency_id = 3526
delete from opds where kabkota_id = 3526 and nama !='Kabupaten Bangkalan'
