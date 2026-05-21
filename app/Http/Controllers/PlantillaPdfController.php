<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionEmpresa;
use Illuminate\Http\Request;

class PlantillaPdfController extends Controller
{
    public function index()
    {
        $empresa = ConfiguracionEmpresa::obtener();

        return view('plantilla-pdf.index', compact('empresa'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cuit' => 'nullable|string|max:50',
            'condicion_fiscal' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'direccion_alternativa' => 'nullable|string|max:255',
            'telefono1' => 'nullable|string|max:50',
            'telefono2' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $empresa = ConfiguracionEmpresa::obtener();

        $empresa->fill($request->only([
            'nombre', 'cuit', 'condicion_fiscal', 'direccion',
            'direccion_alternativa', 'telefono1', 'telefono2', 'email',
        ]));

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $empresa->logo = $logoPath;
        }

        $empresa->save();

        return redirect()->route('dashboard.plantilla-pdf.index')
            ->with('status', 'Configuracion de la plantilla PDF actualizada correctamente');
    }
}
