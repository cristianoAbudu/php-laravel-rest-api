<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\APIBaseController as APIBaseController;
use App\Colaborador;
use Validator;


class ColaboradorAPIController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colaborador = Colaborador::all();
        return $this->sendResponse($colaborador->toArray(), 'Colaborador retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'nome' => 'required',
            'senha' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        $colaborador = Colaborador::create($input);


        return $this->sendResponse($colaborador->toArray(), 'Colaborador created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $colaborador = Colaborador::find($id);


        if (is_null($colaborador)) {
            return $this->sendError('Colaborador not found.');
        }


        return $this->sendResponse($colaborador->toArray(), 'Colaborador retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'nome' => 'required',
            'senha' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        $colaborador = Colaborador::find($id);
        if (is_null($colaborador)) {
            return $this->sendError('Colaborador not found.');
        }


        $colaborador->nome = $input['nome'];
        $colaborador->senha = $input['senha'];
        if(isset($input['score'])){
            $colaborador->score = $input['score'];
        }
        if(isset($input['id_chefe'])){
            $colaborador->id_chefe = $input['id_chefe'];
        }

        $colaborador->save();


        return $this->sendResponse($colaborador->toArray(), 'Colaborador updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $colaborador = Colaborador::find($id);


        if (is_null($colaborador)) {
            return $this->sendError('Colaborador not found.');
        }


        $colaborador->delete();


        return $this->sendResponse($id, 'Tag deleted successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function associaChefe(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'idChefe' => 'required',
            'idSubordinado' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($input['idChefe'] == ($input['idSubordinado'])) {
            return $this->sendError('O id do chefe deve ser diferente do id do subordinado.');
        }

        $chefe = Colaborador::find($input['idChefe']);
        if (is_null($chefe)) {
            return $this->sendError('Chefe not found.');
        }

        $subordinado = Colaborador::find($input['idSubordinado']);
        if (is_null($subordinado)) {
            return $this->sendError('Subordinado not found.');
        }

        $subordinado->id_chefe = $input['idChefe'];

        $subordinado->save();

        return $this->sendResponse($subordinado->toArray(), 'Chefe associado com sucesso.');
    }

}
