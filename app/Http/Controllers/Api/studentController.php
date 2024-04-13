<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class studentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        
        $data =[
            "students" => $students,
            'status' => 200,
        ];
        return response()->json($data, 200);
    }


    //almacenar
    public function store(Request $request)
    {
        //valido campos obligatorios
       $validator = FacadesValidator::make($request->all(), [
            'name'=> 'required|max:255',
            'email'=> 'required|email|unique:student',
            'phone'=> 'required|digits:10',
            'language'=> 'required|in:English,Spanish',
        ]);

        
        if ($validator->fails()) {
            $data = [
                'message' => 'Error Validacion de los Datos',
                'errors' => $validator->errors(),
                'status'=> 400,
            ];
            return response()->json($data, 400);
    }
    //Crear estudiante
    $student = Student::create([
        'name'=> $request->name,
        'email'=> $request->email,
        'phone'=> $request->phone,
        'language' => $request -> language
    ]);

    if (!$student) {
        $data = [
            'message' => 'Error al Crear Estudiante',
            'status'=> 500,
        ];
        return response()->json($data, 500);
    }
    $data = [
        'student' => $student,
        'status'=> 201,
    ];
    return response()->json($data, 201);
}


//Funcion para obtener un estudiante
public function show($id)
{
    $student = Student::find($id);
    if (!$student) {
        $data = [
            'message' => 'Estudiante no Encontrado',
            'status'=> 404,
        ];
        return response()->json($data, 404);
    }
    $data = [
        'student' => $student,
        'status'=> 200,
    ];
    return response()->json($data, 200);
}

//Funcion Eliminar
public function destroy($id)
{
    $student = Student::find($id);
    if (!$student) {
        $data = [
            'message'=> 'Estudiante no Encontrado',
            'status'=> 404,
            ];
            return response()->json($data, 404);
        }
        $student->delete();

        $data = [
            'message'=> 'Estudiante Eliminado',
            'status'=> 200,
        ];
        return response()->json($data, 200);
    }

    //Funcion para Actualizar
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            
            $data = [
                'message'=> 'Estudiante no Encontrado',
                'status'=> 404,
                ];
                return response()->json($data, 404);
            }

               //valido campos obligatorios
        $validator = FacadesValidator::make($request->all(), [
        'name'=> 'required|max:255',
        'email'=> 'required|email|unique:student',
        'phone'=> 'required|digits:10',
        'language'=> 'required|in:English,Spanish',
    ]);

     
    if ($validator->fails()) {
        $data = [
            'message' => 'Error Validacion de los Datos',
            'errors' => $validator->errors(),
            'status'=> 400,
        ];
        return response()->json($data, 400);
       
    }
        $student->name = $request->name;
        $student->email= $request->email;
        $student->phone= $request->phone;
        $student-> language = $request -> language;

        $student -> save();
        $data = [
            'message'=> 'Estudiante Actualizado',
            'student' => $student,
            'status'=> 200,
           ];
    }

    //Funcion para actualizar con patch 
    public function updateParcial(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            
            $data = [
                'message'=> 'Estudiante no Encontrado',
                'status'=> 404,
                ];
                return response()->json($data, 404);
            }
            
            $validator = FacadesValidator::make($request->all(), [
                'name'=> 'max:255',
                'email'=> 'email|unique:student',
                'phone'=> 'digits:10',
                'language'=> 'in:English,Spanish',
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error Validacion de los Datos',
                    'errors' => $validator->errors(),
                    'status'=> 400,
                ];
                return response()->json($data, 400);
             }

             if ($request->has('name')) {
                $student->name = $request->name;
            }
            if ($request->has('email')) {
                $student->email = $request->email;
            }
            if ($request->has('phone')) {
                $student->phone = $request->phone;
            }
            if ($request->has('language')) {
                $student->language = $request->language;
            }

            $student->save();

            $data = [   
                'message'=> 'Estudiante Actualizado',
                'student'=> $student,
                'status'=> 200,
            ];
            return response()->json($data, 200);
        }
}