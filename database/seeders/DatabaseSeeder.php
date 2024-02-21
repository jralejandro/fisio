<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('roles')->insert([
            ['id' => '1', 'rol' => 'ADMINISTRADOR'],
            ['id' => '2', 'rol' => 'RECEPCIONISTA'],
            ['id' => '3', 'rol' => 'DOCTOR'],
            ['id' => '4', 'rol' => 'FISIOTERAPEUTA'],
            ['id' => '5', 'rol' => 'INTERNO'],
            ['id' => '6', 'rol' => 'PACIENTE'],
        ]);

        DB::table('departamentos')->insert([
            ['id' => '1', 'nombre' => 'LA PAZ', 'abreviatura' => 'LP'],
            ['id' => '2', 'nombre' => 'BENI', 'abreviatura' => 'BN'],
            ['id' => '3', 'nombre' => 'CHUQUISACA', 'abreviatura' => 'CH'],
            ['id' => '4', 'nombre' => 'COCHABAMBA', 'abreviatura' => 'CB'],
            ['id' => '5', 'nombre' => 'ORURO', 'abreviatura' => 'OR'],
            ['id' => '6', 'nombre' => 'PANDO', 'abreviatura' => 'PD'],
            ['id' => '7', 'nombre' => 'POTOSI', 'abreviatura' => 'PT'],
            ['id' => '8', 'nombre' => 'SANTA CRUZ', 'abreviatura' => 'SC'],
            ['id' => '9', 'nombre' => 'TARIJA', 'abreviatura' => 'TJ'],
        ]);

        DB::table('turnos')->insert([
            ['id' => '1', 'turno' => 'MAÑANA'],
            ['id' => '2', 'turno' => 'TARDE'],
            ['id' => '3', 'turno' => 'MAÑANA - TARDE'],
        ]);
        
        DB::table('tratamientos')->insert([
            ['id' => '1', 'tratamiento' => 'TERMOTERAPIA'],
            ['id' => '2', 'tratamiento' => 'HIDROTERAPIA'],
            ['id' => '3', 'tratamiento' => 'MASAJE'],
            ['id' => '4', 'tratamiento' => 'ELECTROTERAPIA'],
            ['id' => '5', 'tratamiento' => 'CINESITERAPIA'],
            ['id' => '6', 'tratamiento' => 'MECANOTERAPIA'],
            ['id' => '7', 'tratamiento' => 'TECNICAS ESPECIALES'],
        ]);

        DB::table('horas')->insert([
            ['id' => '1', 'hora' => '08:00', 'turno_id' => '1', 'rol_id' => '4'],
            ['id' => '2', 'hora' => '08:30', 'turno_id' => '1', 'rol_id' => '4'],
            ['id' => '3', 'hora' => '09:00', 'turno_id' => '1', 'rol_id' => '4'],
            ['id' => '4', 'hora' => '09:30', 'turno_id' => '1', 'rol_id' => '4'],
            ['id' => '5', 'hora' => '10:00', 'turno_id' => '1', 'rol_id' => '4'],
            ['id' => '6', 'hora' => '10:30', 'turno_id' => '1', 'rol_id' => '4'],
            ['id' => '7', 'hora' => '11:00', 'turno_id' => '1', 'rol_id' => '4'],
            ['id' => '8', 'hora' => '11:30', 'turno_id' => '1', 'rol_id' => '4'],
            ['id' => '9', 'hora' => '12:00', 'turno_id' => '1', 'rol_id' => '4'],
            ['id' => '10', 'hora' => '12:30', 'turno_id' => '1', 'rol_id' => '4'],
            ['id' => '11', 'hora' => '14:00', 'turno_id' => '2', 'rol_id' => '4'],
            ['id' => '12', 'hora' => '14:30', 'turno_id' => '2', 'rol_id' => '4'],
            ['id' => '13', 'hora' => '15:00', 'turno_id' => '2', 'rol_id' => '4'],
            ['id' => '14', 'hora' => '15:30', 'turno_id' => '2', 'rol_id' => '4'],
            ['id' => '15', 'hora' => '16:00', 'turno_id' => '2', 'rol_id' => '4'],
            ['id' => '16', 'hora' => '16:30', 'turno_id' => '2', 'rol_id' => '4'],
            ['id' => '17', 'hora' => '17:00', 'turno_id' => '2', 'rol_id' => '4'],
            ['id' => '18', 'hora' => '17:30', 'turno_id' => '2', 'rol_id' => '4'],
            ['id' => '19', 'hora' => '18:00', 'turno_id' => '2', 'rol_id' => '4'],
            ['id' => '20', 'hora' => '18:30', 'turno_id' => '2', 'rol_id' => '4'],
            
            ['id' => '21', 'hora' => '08:00', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '22', 'hora' => '08:15', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '23', 'hora' => '08:30', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '24', 'hora' => '08:45', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '25', 'hora' => '09:00', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '26', 'hora' => '09:15', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '27', 'hora' => '09:30', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '28', 'hora' => '09:45', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '29', 'hora' => '10:00', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '30', 'hora' => '10:15', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '31', 'hora' => '10:30', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '32', 'hora' => '10:45', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '33', 'hora' => '11:00', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '34', 'hora' => '11:15', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '35', 'hora' => '11:30', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '36', 'hora' => '11:45', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '37', 'hora' => '12:00', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '38', 'hora' => '12:15', 'turno_id' => '1', 'rol_id' => '3'],
            ['id' => '39', 'hora' => '14:00', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '40', 'hora' => '14:15', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '41', 'hora' => '14:30', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '42', 'hora' => '14:45', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '43', 'hora' => '15:00', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '44', 'hora' => '15:15', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '45', 'hora' => '15:30', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '46', 'hora' => '15:45', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '47', 'hora' => '16:00', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '48', 'hora' => '16:15', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '49', 'hora' => '16:30', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '50', 'hora' => '16:45', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '51', 'hora' => '17:00', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '52', 'hora' => '17:15', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '53', 'hora' => '17:30', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '54', 'hora' => '17:45', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '55', 'hora' => '18:00', 'turno_id' => '2', 'rol_id' => '3'],
            ['id' => '56', 'hora' => '18:15', 'turno_id' => '2', 'rol_id' => '3'],
                        
            ['id' => '57', 'hora' => '08:00', 'turno_id' => '1', 'rol_id' => '5'],
            ['id' => '58', 'hora' => '08:30', 'turno_id' => '1', 'rol_id' => '5'],
            ['id' => '59', 'hora' => '09:00', 'turno_id' => '1', 'rol_id' => '5'],
            ['id' => '60', 'hora' => '09:30', 'turno_id' => '1', 'rol_id' => '5'],
            ['id' => '61', 'hora' => '10:00', 'turno_id' => '1', 'rol_id' => '5'],
            ['id' => '62', 'hora' => '10:30', 'turno_id' => '1', 'rol_id' => '5'],
            ['id' => '63', 'hora' => '11:00', 'turno_id' => '1', 'rol_id' => '5'],
            ['id' => '64', 'hora' => '11:30', 'turno_id' => '1', 'rol_id' => '5'],
            ['id' => '65', 'hora' => '12:00', 'turno_id' => '1', 'rol_id' => '5'],
            ['id' => '66', 'hora' => '12:30', 'turno_id' => '1', 'rol_id' => '5'],
            ['id' => '67', 'hora' => '14:00', 'turno_id' => '2', 'rol_id' => '5'],
            ['id' => '68', 'hora' => '14:30', 'turno_id' => '2', 'rol_id' => '5'],
            ['id' => '69', 'hora' => '15:00', 'turno_id' => '2', 'rol_id' => '5'],
            ['id' => '70', 'hora' => '15:30', 'turno_id' => '2', 'rol_id' => '5'],
            ['id' => '71', 'hora' => '16:00', 'turno_id' => '2', 'rol_id' => '5'],
            ['id' => '72', 'hora' => '16:30', 'turno_id' => '2', 'rol_id' => '5'],
            ['id' => '73', 'hora' => '17:00', 'turno_id' => '2', 'rol_id' => '5'],
            ['id' => '74', 'hora' => '17:30', 'turno_id' => '2', 'rol_id' => '5'],
            ['id' => '75', 'hora' => '18:00', 'turno_id' => '2', 'rol_id' => '5'],
            ['id' => '76', 'hora' => '18:30', 'turno_id' => '2', 'rol_id' => '5'],
        ]);

    }
}
