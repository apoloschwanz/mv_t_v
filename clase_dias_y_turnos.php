<?php

	"SELECT Dia_Nro, Dia_Nombre, Turno,  Turno_ID  FROM dias_semana , turnos WHERE Dia_Nro > 1 and Dia_Nro < 7 and Turno_ID in ('M','T','N') order by Dia_Nro, Turno_orden" ;

?>
