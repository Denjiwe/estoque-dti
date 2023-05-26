<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Divisao;
use App\Models\Suprimento;
use App\Models\Diretoria;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function __construct(Produto $produto) {
        $this->produto = $produto;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = $this->produto->paginate(10);

        return view('produto.index', ['produtos' => $produtos, 'titulo' => 'Produtos Cadastrados']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->produto->rules($request, 0), $this->produto->feedback());

        $produto = $this->produto->create($request->all());

        // return response()->json($produto, 201);
        switch ($request->proximo) {
            case 'locais':
                // caso seja uma impressora
                return redirect()->route('produtos.locais', ['id' => $produto->id]);
                break;
            case 'impressoras':
                // caso seja um toner ou cilíndro
                return redirect()->route('produtos.impressoras', ['id' => $produto->id]);
                break;
            case 'nenhum':
                // caso seja outros
                return redirect()->route('produtos.index');
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = $this->produto->find($id);

        if ($produto == null) {
            return redirect()->route('produtos.index');
        }

        return view('produto.edit', ['produto' => $produto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = $this->produto->find($id);

        if ($produto == null) {
            return redirect()->route('produtos.index');
        }

        $request->validate($this->produto->rules($request, $produto->id), $this->produto->feedback());

        $produto->update($request->all());

        // return response()->json($produto, 201);
        switch ($request->proximo) {
            case 'locais':
                // caso seja uma impressora
                return redirect()->route('locais.create', ['id' => $produto->id]);
                break;
            case 'impressoras':
                // caso seja um toner ou cilíndro
                return redirect()->route('produtos.impressoras', ['id' => $produto->id]);
                break;
            case 'nenhum':
                // caso seja outros
                return redirect()->route('produtos.index');
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = $this->produto->find($id);

        $produto->delete();

        return redirect()->route('produtos.index');
    }

    public function toners()
    {
        $toners = $this->produto->select('id','modelo_produto')->where([['tipo_produto', 'TONER'], ['status', 'ATIVO']])->get();

        return response()->json($toners, 200);
    }
    
    public function cilindros()
    {
        $cilindros = $this->produto->select('id','modelo_produto')->where([['tipo_produto', 'CILINDRO'], ['status', 'ATIVO']])->get();

        return response()->json($cilindros, 200);
    }
}
