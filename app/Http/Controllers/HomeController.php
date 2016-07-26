<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Sintegra;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function consulta()
    {   
        $bat = false;
        return view('consulta', compact('bat'));
    }

    public function getConsulta(Request $request)
    {
        $cnpj = $request->cnpj;
        $post = array (
                'num_cnpj' => $cnpj,
                'botao' => 'Consultar' 
        );
        
        $userAgent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36';

        $h = curl_init ( 'http://www.sintegra.es.gov.br/resultado.php' );
        curl_setopt ( $h, CURLOPT_USERAGENT, $userAgent );
        curl_setopt ( $h, CURLOPT_POST, true );
        curl_setopt ( $h, CURLOPT_POSTFIELDS, (is_array ( $post ) ? http_build_query ( $post, '', '&' ) : $post) );
        curl_setopt ( $h, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $h, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt ( $h, CURLOPT_HEADER, 1 );
        $result = curl_exec ( $h );
        
        if (strlen ( $result ) > 0) {
            $data ['Sucesss'] = true;
        } else {
            $data ['Success'] = false;
        }
        $recepe = $this->getSintegraES($result, 'td', 'valor');
        
        if ($recepe == false) {
            return redirect('consulta')->with('status', 'Tipo de dados inválido para o campo CNPJ !');
        }else{

            $myJsonString = json_encode($recepe);
            // dd($myJsonString);
            

            Auth::user()->Sintegra()->create([
                'cnpj' => $cnpj,
                'resultado_json' => $myJsonString,
            ]);

            $bat = true;
            return view('consulta', compact('recepe', 'bat'));
        }
        
    }

    function nodeContent($n, $outer = false) {
        $d = new \DOMDocument ( '1.0' );
        
        if ($n == null) {
            return false;
        }

        $b = $d->importNode ( $n->cloneNode ( true ), true );
        $d->appendChild ( $b );
        $h = $d->saveHTML ();
        if (! $outer)
            $h = substr ( $h, strpos ( $h, '>' ) + 1, - (strlen ( $n->nodeName ) + 4) );
        return $h;
    }

    function getSintegraES($html, $element, $class) {
        $results = array ();
        $allData = array ();

        $query = "//$element" . "[@class='" . $class . "']";
        $dom = new \DOMDocument();
        @$dom->loadHTML ( $html );
        $xpath = new \DOMXPath ( $dom );
        $result = $xpath->query ( $query );

        if (!$this->nodeContent ( $result->item ( 0 ))) {
            return false;
        }

        $cnpj = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 0 ) ) );
        $ie = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 1 ) ) );
        
        $razao = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 2 ) ) );
        $logradouro = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 3 ) ) );
        $numero = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 4 ) ) );
        $complemento = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 5 ) ) ); 
        $bairro = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 6 ) ) );
        $municipio = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 7 ) ) );
        $estado = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 8 ) ) );
        $cep = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 9 ) ) );
        $telefone = str_replace ( array ('&nbsp;','.','/','-',' '), '', $this->nodeContent ( $result->item ( 10 ) ) );
        $atividade = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 11 ) ) );
        $inicio = str_replace ( array ('&nbsp;','.','-'), '', $this->nodeContent ( $result->item ( 12 ) ) );
        $inicio = explode ( '/', $inicio );
        $inicio = $inicio [2] . '-' . $inicio [1] . '-' . $inicio [0];
        $situacao = str_replace ( array ('&nbsp;','.','/','-' ), '', $this->nodeContent ( $result->item ( 13 ) ) );
        $data_situacao = str_replace ( array ('&nbsp;','.','-'), '', $this->nodeContent ( $result->item ( 14 ) ) );
        $data_situacao = explode ( '/', $data_situacao );
        $data_situacao = $data_situacao [2] . '-' . $data_situacao [1] . '-' . $data_situacao [0];
        $regime = str_replace ( array ('&nbsp;','.','/','-'), '', $this->nodeContent ( $result->item ( 15 ) ) );
        $nfe = str_replace ( array ('&nbsp;','.','-'), '', $this->nodeContent ( $result->item ( 16 ) ) );
        $nfe = explode ( '/', $nfe );
        $nfe = $nfe [2] . '-' . $nfe [1] . '-' . $nfe [0];

        $allData = [$cnpj,$ie,$razao,$logradouro,$numero,
                    $complemento,$bairro,$municipio,$estado,
                    $cep,$telefone,$atividade,$inicio,$situacao,
                    $data_situacao,$regime,$nfe];

        return $allData;
    }

    public function getMyConsultas()
    {   

        $consulta = DB::table('sintegras')
                    ->where('user_id', '=',\Auth::user()->id)
                    ->get();

        
        return view('minhasConsultas', compact('consulta'));
    }

    public function Destroy(Request $request)
    {   
        // $bat = false;

        $id = $request->id;

        $task = Sintegra::findOrFail($id);

        $task->delete();


        return redirect('consulta');
        // redirect('adm_trimestre');
                

    }
}
