
insert  into `roles` values 
(1,'ROOT','Root',NULL),
(2,'ADM','Administrador',NULL),
(3,'EST','Estudiante',NULL),
(4,'DOC','Docente',NULL),
(5,'REG','Registros',NULL),
(6,'DIS','Deshabilitado',NULL);

insert  into `users` values 
(1,'john','$2y$10$G3APTqEBJ3iADrUr40WV2u3VvzLVJ4xRWrClP4WCPj9hRDAgwu3pa',1,'NTVHOKVgtiJcXMnSIi4iYTYMpozrHeB2ifrFaLPCGK6kn8dKnx34DGBIpE6D','2017-07-07 17:18:12','2017-07-17 10:47:33',NULL);

insert  into `offices`values 
(1,'CENTRAL COCHABAMBA','C/Jordan #681, e/ Antezana y Lanza, Edif. Ferrufino Of. 4');

insert  into `menus` values 
(1,'MMEN','Menus','bars'),
(2,'MFUN','Funcionalidades','bar-chart'),
(3,'MROL','Roles','key'),
(4,'MUSR','Usuarios','user'),
(5,'MCLI','Estudiantes','users'),
(6,'MDOC','Docentes','male'),
(7,'MOFF','Sucursal','home'),
(8,'CAR','Carreras','car'),
(9,'SUB','Asignaturas','book'),
(10,'EMP','Empleados','briefcase');

insert  into `functionalities` values 
(1,'CMEN','Crear Menu','admin/menu/create',1),
(2,'EMEN','Editar Menu','admin/menu/edit',1),
(3,'DMEN','Borar Menu','admin/menu/delete',1),
(4,'MEN','Ver Menu','admin/menu',1),
(5,'CFUN','Crear Funcionalidad','admin/functionality/create',2),
(6,'EFUN','Editar Funcionalidad','admin/functionality/edit',2),
(7,'DFUN','Borar Funcionalidad','admin/functionality/delete',2),
(8,'FUN','Ver Funcionalidad','admin/functionality',2),
(9,'CROL','Crear Roles','admin/role/create',3),
(10,'EROL','Editar Roles','admin/role/edit',3),
(11,'DROL','Borar Roles','admin/role/delete',3),
(12,'ROL','Ver Roles','admin/role',3),
(13,'CUSR','Crear Usuarios','user/create',4),
(14,'EUSR','Editar Usuario','user/edit',4),
(15,'DUSR','Borar Usuarios','user/delete',4),
(16,'USR','Ver Usuarios','user',4),
(17,'CEST','Crear Estudiante','admin/student/create',5),
(18,'EEST','Editar Estudiante','admin/student/edit',5),
(19,'DEST','Borar Estudiantes','admin/student/delete',5),
(20,'EST','Ver Estudiantes','admin/student',5),
(21,'CDOC','Crear Docente','admin/teacher/create',6),
(22,'EDOC','Editar Docentes','admin/teacher/edit',6),
(23,'DDOC','Borar Docentes','admin/teacher/delete',6),
(24,'DOC','Ver Docentes','admin/teacher',6),
(25,'COFF','Crear Sucursal','admin/office/create',7),
(26,'EOFF','Editar Sucursal','admin/office/edit',7),
(27,'DOFF','Eliminar Sucursal','admin/office/delete',7),
(28,'OFF','Ver Sucursales','admin/office',7),
(29,'CCAR','Crear Carrera','admin/career/create',8),
(30,'ECAR','Editar Carrera','admin/career/edit',8),
(31,'DCAR','Borrar Carrera','admin/career/delete',8),
(32,'CAR','Ver Carrerras','admin/career',8),
(33,'CSUB','Crear Asignatura','admin/subject/create',9),
(34,'ESUB','Editar Asignatura','admin/subject/edit',9),
(35,'DSUB','Eliminar Asignatura','admin/subject/delete',9),
(36,'SUB','Ver Asignaturas','admin/subject',9),
(37,'CEMP','Crear Empleado','admin/employee/create',10),
(38,'EEMP','Editar Empleado','admin/employee/edit',10),
(39,'DEMP','Eliminar Empleado','admin/employee/delete',10),
(40,'EMP','Ver Empleados','admin/employee',10);

insert  into `privileges`(`id`,`functionality_id`,`role_id`) values 
(1,1,1),
(2,2,1),
(3,3,1),
(4,4,1),
(5,5,1),
(6,6,1),
(7,7,1),
(8,8,1),
(9,9,1),
(10,10,1),
(11,11,1),
(12,12,1),
(13,13,1),
(14,14,1),
(15,15,1),
(16,16,1),
(17,17,1),
(18,18,1),
(19,19,1),
(20,20,1),
(21,21,1),
(22,22,1),
(23,23,1),
(24,24,1),
(25,25,1),
(26,26,1),
(27,27,1),
(28,28,1),
(29,29,1),
(30,30,1),
(31,31,1),
(32,32,1),
(33,33,1),
(34,34,1),
(35,35,1),
(36,36,1),
(37,37,1),
(38,38,1),
(39,39,1),
(40,40,1);
