<?php

class TestGoniometroTableSeeder extends Seeder {

	public function run()
	{
		// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		// app\models\Protocols\Tests\Goniometro\Paramgroup::truncate();
		// app\models\Protocols\Tests\Goniometro\Param::truncate();
		// DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		
/*
INSERT INTO `test_goniometro_paramgroup` (`id`,`name`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (1,'MS - Ombro',1,1,'2014-12-27 15:23:34','2014-12-27 15:23:34',NULL);
INSERT INTO `test_goniometro_paramgroup` (`id`,`name`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (2,'MS - Cotovelo',2,1,'2014-12-27 15:27:03','2014-12-27 15:27:03',NULL);
INSERT INTO `test_goniometro_paramgroup` (`id`,`name`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (3,'MS - Rádio-ulnar',3,1,'2014-12-27 15:28:41','2014-12-27 15:28:41',NULL);
INSERT INTO `test_goniometro_paramgroup` (`id`,`name`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (4,'MS - Punho',4,1,'2014-12-27 15:29:35','2014-12-27 15:29:35',NULL);
INSERT INTO `test_goniometro_paramgroup` (`id`,`name`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (5,'MS - Metacarpofalangeana (MCF)',5,1,'2014-12-27 15:31:50','2014-12-27 15:31:50',NULL);
INSERT INTO `test_goniometro_paramgroup` (`id`,`name`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (6,'MS - Interfalangeana (IF)',6,1,'2014-12-27 15:34:52','2014-12-27 15:34:52',NULL);
INSERT INTO `test_goniometro_paramgroup` (`id`,`name`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (7,'MI - Quadril',7,1,'2014-12-27 15:36:49','2014-12-27 15:36:49',NULL);
INSERT INTO `test_goniometro_paramgroup` (`id`,`name`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (8,'MI - Joelho',8,1,'2014-12-27 15:38:18','2014-12-27 15:38:18',NULL);
INSERT INTO `test_goniometro_paramgroup` (`id`,`name`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (9,'MI - Tornozelo',9,1,'2014-12-27 15:39:19','2014-12-27 15:39:19',NULL);
INSERT INTO `test_goniometro_paramgroup` (`id`,`name`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (10,'MI - Metatarsofalangeana',10,1,'2014-12-27 15:41:59','2014-12-27 15:41:59',NULL);
INSERT INTO `test_goniometro_paramgroup` (`id`,`name`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (11,'MI - Interfalangeana',11,1,'2014-12-27 16:06:08','2014-12-27 16:06:08',NULL);
*/

/*
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (1,1,'Flexão','0-180',1,1,'2014-12-27 15:23:34','2014-12-27 15:23:34',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (2,1,'Extensão','0-45',2,1,'2014-12-27 15:24:06','2014-12-27 15:24:06',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (3,1,'Abdução','0-180',3,1,'2014-12-27 15:24:29','2014-12-27 15:24:29',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (4,1,'Abdução horizontal','0-40',4,1,'2014-12-27 15:25:00','2014-12-27 15:25:00',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (5,1,'Adução horizontal','0-135',5,1,'2014-12-27 15:25:26','2014-12-27 15:25:26',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (6,1,'Rotação interna','0-90',6,1,'2014-12-27 15:25:58','2014-12-27 15:25:58',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (7,1,'Rotação externa','0-90',7,1,'2014-12-27 15:26:16','2014-12-27 15:26:16',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (8,2,'Flexão','0-140',8,1,'2014-12-27 15:27:03','2016-08-10 14:02:08',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (9,2,'Extensão','0-90',9,1,'2014-12-27 15:27:34','2014-12-27 15:27:34',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (10,3,'Pronação','0-90',10,1,'2014-12-27 15:28:41','2014-12-27 15:28:41',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (11,3,'Supinação','0-90',11,1,'2014-12-27 15:29:02','2014-12-27 15:29:02',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (12,4,'Flexão','0-80',12,1,'2014-12-27 15:29:35','2016-07-07 16:06:46',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (13,4,'Extensão','0-70',13,1,'2014-12-27 15:30:01','2014-12-27 15:30:01',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (14,4,'Desvio radial','0-45',14,1,'2014-12-27 15:30:29','2015-08-11 13:25:57','2015-08-11 13:25:57');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (15,4,'Desvio Ulnar ','0-30',15,1,'2014-12-27 15:30:53','2016-07-07 15:45:20',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (16,5,'Flexão polegar ','0-90',16,1,'2014-12-27 15:31:50','2015-07-07 20:57:49',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (17,5,'Extensão','0-30',17,1,'2014-12-27 15:32:05','2016-07-07 15:43:22','2016-07-07 15:43:22');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (18,5,'Abdução','0-20',18,1,'2014-12-27 15:32:44','2014-12-27 15:32:44',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (19,5,'Adução','0-20',19,1,'2014-12-27 15:33:14','2014-12-27 15:33:14',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (20,6,'Flexão - 1º dedo IFD','0-80',20,1,'2014-12-27 15:34:52','2015-01-09 12:43:59','2015-01-09 12:43:59');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (21,6,'Extensão - 1º dedo','0-10',21,1,'2014-12-27 15:35:23','2014-12-27 16:00:52',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (22,7,'Flexão','0-125',22,1,'2014-12-27 15:36:49','2014-12-27 15:36:49',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (23,7,'Extensão','0-10',23,1,'2014-12-27 15:37:07','2014-12-27 15:37:07',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (24,7,'Rotação interna','0-45',24,1,'2014-12-27 15:37:29','2014-12-27 15:37:29',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (25,7,'Rotação externa','0-45',25,1,'2014-12-27 15:37:49','2014-12-27 15:37:49',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (26,8,'Flexão','0-140',26,1,'2014-12-27 15:38:18','2014-12-27 15:38:18',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (27,9,'Dorsi Flexão ','0-20',27,1,'2014-12-27 15:39:19','2016-02-11 16:06:45',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (28,9,'Planti Flexão ','0-45',28,1,'2014-12-27 15:39:42','2016-02-11 16:08:11',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (29,9,'Inversão','0-20',29,1,'2014-12-27 15:39:57','2014-12-27 15:39:57',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (30,9,'Eversão','0-40',30,1,'2014-12-27 15:40:15','2014-12-27 15:40:15',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (31,10,'Flexão - 1º dedo','0-45',31,1,'2014-12-27 15:41:59','2014-12-27 15:43:40',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (32,10,'Flexão - 2º dedo','0-40',32,1,'2014-12-27 15:44:22','2014-12-27 15:44:22',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (33,10,'Flexão - 3º dedo','0-40',33,1,'2014-12-27 15:44:48','2014-12-27 15:44:48',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (34,10,'Flexão - 4º dedo','0-40',34,1,'2014-12-27 15:45:24','2014-12-27 15:45:24',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (35,10,'Flexão - 5º dedo','0-40',35,1,'2014-12-27 15:47:00','2014-12-27 15:47:00',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (36,10,'Extensão - 1º dedo','0-90',36,1,'2014-12-27 15:48:39','2014-12-27 15:48:39',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (37,10,'Extensão - 2º dedo','0-45',37,1,'2014-12-27 15:49:12','2014-12-27 15:49:12',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (38,10,'Extensão - 3º dedo','0-45',38,1,'2014-12-27 15:49:51','2014-12-27 15:49:51',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (39,10,'Extensão - 4º dedo','0-45',39,1,'2014-12-27 15:50:19','2014-12-27 15:50:19',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (40,10,'Extensão - 5º dedo','0-45',40,1,'2014-12-27 15:50:42','2014-12-27 15:50:42',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (41,6,'Flexão - 2º dedo','0-110',41,1,'2014-12-27 15:57:57','2016-07-07 14:59:26','2016-07-07 14:59:26');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (42,6,'Flexão - 3º dedo','0-110',42,1,'2014-12-27 15:59:16','2016-07-07 14:59:02','2016-07-07 14:59:02');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (43,6,'Flexão - 4º dedo','0-110',43,1,'2014-12-27 15:59:49','2016-07-07 15:55:17','2016-07-07 15:55:17');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (44,6,'Flexão - 5º dedo','0-110',44,1,'2014-12-27 16:00:14','2016-07-07 15:58:17','2016-07-07 15:58:17');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (45,6,'Extensão - 2º dedo','0-10',45,1,'2014-12-27 16:00:34','2014-12-27 16:00:34',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (46,6,'Extensão - 3º dedo','0-10',46,1,'2014-12-27 16:01:42','2014-12-27 16:01:42',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (47,6,'Extensão - 4º dedo','0-10',47,1,'2014-12-27 16:02:00','2014-12-27 16:02:00',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (48,6,'Extensão - 5º dedo','0-10',48,1,'2014-12-27 16:02:18','2014-12-27 16:02:18',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (49,11,'Flexão - 1º dedo','0-90',49,1,'2014-12-27 16:06:08','2014-12-27 16:06:08',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (50,11,'Flexão proximal - 2º dedo ','0-35',50,1,'2014-12-27 16:07:52','2014-12-27 16:07:52',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (51,11,'Flexão proximal - 3º dedo ','0-35',51,1,'2014-12-27 16:08:46','2014-12-27 16:08:46',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (52,11,'Flexão proximal - 4º dedo','0-35',52,1,'2014-12-27 16:09:08','2014-12-27 16:09:08',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (53,11,'Flexão proximal - 5º dedo','0-35',53,1,'2014-12-27 16:09:29','2014-12-27 16:09:29',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (54,11,'Flexão distal - 2º dedo','0-60',54,1,'2014-12-27 16:09:57','2014-12-27 16:09:57',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (55,11,'Flexão distal - 3º dedo','0-60',55,1,'2014-12-27 16:11:12','2014-12-27 16:11:12',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (56,11,'Flexão distal - 4º dedo','0-60',56,1,'2014-12-27 16:11:30','2014-12-27 16:11:30',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (57,11,'Flexão distal - 5º dedo','0-60',57,1,'2014-12-27 16:11:49','2014-12-27 16:11:49',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (58,6,'Flexão - 1º dedo IFP','0-110',58,1,'2015-01-09 12:37:12','2015-11-03 16:49:03','2015-11-03 16:49:03');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (59,6,'Flexão - 2º dedo IFP','0-100',59,1,'2015-01-09 12:38:47','2016-07-07 14:59:45',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (60,6,'Flexão - 2º dedo IFD','0-90',60,1,'2015-01-09 12:40:19','2016-06-16 18:00:50',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (61,6,'Flexão - 3º dedo IFP','0-100',61,1,'2015-01-09 12:40:56','2016-07-07 15:46:25',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (62,5,'Flexão  MF polegar ','0-50',62,1,'2015-01-09 12:42:09','2017-06-07 18:39:09',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (63,6,'Flexão - 4º dedo IFP','0-100',63,1,'2015-01-09 12:42:57','2016-07-07 15:58:48',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (64,6,'Flexão - 3º dedo IFD','0-90',64,1,'2015-01-09 12:45:00','2016-07-07 15:00:21',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (65,6,'Flexão - 4º dedo IFD','0-90',65,1,'2015-01-09 12:45:44','2016-07-07 15:58:01',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (66,1,'Flexão - 5º dedo IFP','0-80',66,1,'2015-01-09 12:46:23','2015-01-09 13:01:25','2015-01-09 13:01:25');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (67,6,'Flexão - 5º dedo IFP','0-100',67,1,'2015-01-09 12:47:38','2016-07-07 14:57:10',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (68,6,'Flexão - 5º dedo IFD','0-90',68,1,'2015-01-09 12:48:18','2016-07-07 15:59:45',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (69,6,'MS-  flexão  de todas Interfalangeanas proximais ','0-100',69,1,'2015-01-12 13:44:35','2016-07-07 15:54:47','2016-07-07 15:54:47');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (70,6,'MS-  flexão de todas as Interfalangeanas distais ','0-90',70,1,'2015-01-12 13:50:01','2016-07-07 15:54:58','2016-07-07 15:54:58');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (71,5,'Flexão 2º dedo ','0-90',71,1,'2015-02-02 16:56:55','2016-07-07 15:49:59',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (72,5,'Flexão 3º dedo','0-90',72,1,'2015-02-02 16:57:32','2016-07-07 15:50:17',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (73,5,'Flexão 4º dedo','0-90',73,1,'2015-02-02 16:58:04','2016-07-07 15:50:34',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (74,5,'Flexão 5º dedo ','0-90',74,1,'2015-02-02 16:58:35','2016-07-07 15:50:53',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (75,1,'Rotação Interna','L2',75,1,'2015-07-24 20:59:04','2015-07-24 21:06:50',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (76,1,'Rotação Interna ','T8',76,1,'2015-07-24 21:06:05','2015-07-24 21:07:30',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (77,1,'Rotação Interna ','L4',77,1,'2015-07-24 21:32:29','2015-07-24 21:32:29',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (78,1,'Rotação Interna ','T10',78,1,'2015-07-24 21:35:53','2015-07-24 21:35:53',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (79,1,'Rotação Interna ','T12',79,1,'2015-07-24 21:36:20','2015-07-24 21:36:20',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (80,7,'Rotação Interna ','GrandeTrocantes',80,1,'2015-07-24 21:36:57','2015-09-01 16:09:17',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (81,7,'Rotação Interna ','Nádegas',81,1,'2015-07-24 21:38:21','2015-09-01 16:09:29',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (82,1,'Rotação Interna ','T7',82,1,'2015-07-24 21:39:54','2015-07-24 21:39:54',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (83,4,'Desvio radial ','0-20',83,1,'2015-08-11 13:28:08','2016-07-07 15:45:00',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (84,5,'MS - Metacarpofalangeana (MCF)','0-90',84,1,'2015-08-11 13:35:05','2015-08-11 13:35:18','2015-08-11 13:35:18');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (85,5,'Flexão ','0-90',85,1,'2015-08-11 13:35:40','2016-07-07 15:49:11','2016-07-07 15:49:11');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (86,6,'Extensão - 5º dedo','10°',86,1,'2015-09-17 21:40:25','2016-07-07 15:48:48','2016-07-07 15:48:48');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (87,6,'extensão de todas as interfalangeanas distais','0-20',87,1,'2015-11-02 23:01:47','2016-07-07 15:54:21','2016-07-07 15:54:21');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (88,6,'extensão de todas interfalangeanas proximais','0-10',88,1,'2015-11-02 23:03:16','2016-07-07 15:54:31','2016-07-07 15:54:31');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (89,5,'Flexão','50°',89,1,'2015-11-03 16:59:52','2016-07-07 15:46:46','2016-07-07 15:46:46');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (90,5,'Extensão ','0-30',90,1,'2016-02-10 17:45:14','2016-07-07 15:49:29','2016-07-07 15:49:29');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (91,5,'Extensão de todas metacarpos falangeanas','0-30',91,1,'2016-02-20 13:20:20','2016-07-07 15:47:05','2016-07-07 15:47:05');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (92,10,'Extensão do 5º metacarpo','0-15',92,1,'2016-07-07 16:09:11','2016-07-07 16:11:19',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (93,6,'Extensão do 5º interfalangeana ','0-15',93,1,'2016-07-07 16:10:16','2016-07-07 16:10:41','2016-07-07 16:10:41');
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (94,5,'Flexão ','0-90',94,1,'2016-12-02 16:18:58','2016-12-02 16:18:58',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (95,5,'Flexão ','0-90',95,1,'2016-12-02 16:21:03','2016-12-02 16:21:03',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (96,5,'Flexão','0-90',96,1,'2016-12-02 16:30:03','2017-03-09 15:16:37',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (97,5,'Extensão ','0-30',97,1,'2017-03-13 15:08:01','2017-03-13 15:08:39',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (98,11,'Extensão ','0-30',98,1,'2017-03-13 15:10:46','2017-03-13 15:28:59',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (99,11,'Flexão IFP','0-100',99,1,'2017-03-13 15:12:14','2017-03-13 15:12:14',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (100,11,'Flexão ','0-100',100,1,'2017-03-13 15:14:01','2017-03-13 15:14:01',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (101,6,'Extensão ','0-30',101,1,'2017-03-13 15:28:28','2017-03-13 15:29:14',NULL);
INSERT INTO `test_goniometro_param` (`id`,`paramgroup_id`,`name`,`reference`,`sort`,`enabled`,`created_at`,`updated_at`,`deleted_at`) VALUES (102,6,'Extensão IFD','0-10',102,1,'2017-11-01 19:15:25','2017-11-01 19:16:21',NULL);
*/

	}

}
