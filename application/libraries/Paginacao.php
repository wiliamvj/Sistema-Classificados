<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paginacao {

    private $pagina;
    private $qtd;
    private $inicio;
    private $totalGeral = 0;
    private $mudaPagina;

    public function config($limite = FALSE) {
        $this->setPagina(($this->get('p') > 0) ? (int) $this->get('p') : 1);
        $this->setQtd(1);
        ($limite > 0) ? $this->Limite($limite) : $this->Limite(50);
    }

    function baseUrl() {
        return base_url();
    }

    public function get($get) {
        return $_GET[$get];
    }

    public function selected($marcado, $atual) {
        if ($marcado == $atual):
            return 'selected="selected"';
        endif;
    }

//calcular o total de pagina
    public function getTotalPagina($counts) {
        $total = ceil($counts / $this->getQtd());
        return $total;
    }

//fim total de registro.
    //methos limte com a op??o de passa os parametros conforme a necessidade...
    public function Limite($limite = 10) {
        $this->setQtd(($this->get('offset') > 0) ? (int) $this->get('offset') : $limite);
        $this->setInicio($this->getQtd() * $this->getPagina() - $this->getQtd());
    }

    public function urlString($url) {
        if ($url) {
            $string = explode('?', $url);

            if (count($string) > 1) {
                return $url . '&offset=';
            }

            return $url . '/?offset=';
        }
    }

    public function uriString($url) {
        if ($url) {
            $string = explode('?', $url);

            if (count($string) > 1) {
                return $url . '&p=';
            }

            return $url . '/?p=';
        }
    }

    public function uriStringBusca($url) {
        if ($url) {
            $string = explode('?', $url);

            if (count($string) > 1) {
                return $url . '&search=';
            }

            return $url . '/?search=';
        }
    }

    public function mudaPaginacao($url, $link, $ajax = FALSE, $janela = 'container') {
        if ($ajax === TRUE) {
            return "loadingPaginacao('" . $this->baseUrl() . $this->uriString($url) . $link . "', '" . $janela . "');";
        }

        return "mudaPagina('" . $this->uriString($url) . $link . "');";
    }

    public function offSet($url, $link, $ajax = FALSE, $janela = 'container') {
        if ($ajax === TRUE) {
            return "loadingPaginacao('" . $this->baseUrl() . $this->urlString($url) . "'+" . $link . ", '" . $janela . "');";
        }

        return "mudaPagina('" . $this->urlString($url) . "'+" . $link . ");";
    }

    public function busca($url, $link, $ajax = FALSE, $janela = 'container') {
        if ($ajax === TRUE) {
            return "loadingPaginacao('" . $this->baseUrl() . '/' . $this->uriStringBusca($url) . "'+" . $link . ", '" . $janela . "');";
        }

        return "mudaPagina('" . $this->uriStringBusca($url) . "'+" . $link . ");";
    }

    public function reconstruiQueryString($pagina) {

        if (!empty($_SERVER['QUERY_STRING'])) {
            if ($_GET['p'] > 0 and $_GET['p'] <> $pagina) {
                array_shift($_GET);
            }

            if (count($_GET) > 0) {
                $url = '&';
            }
            return $url . http_build_query(array_merge($_GET));
        } else {

            return false;
        }
    }

    //methodo para mostrar a paginação
    public function exibirPaginacao($pagina, $totalPg, $url, $totalRegistro = FALSE, $ajax = FALSE, $janela = 'container') {
        $prev = $pagina - 1;
        $next = $pagina + 1;
        $maxLinks = $this->getPagina();
        $pgAtual = $this->getPagina();
        $inicio = 1;


        if ($totalPg > 1) {
            //$html = '<div style="float: left; display:none;">Mostrando ' . $this->getQtd() . ' de ' . $totalRegistro . ' registros</div>';
            $html .='<div class="pagination-box jPaginate" style="padding-left: 35px;">';
            $html .='<div style="overflow: hidden; width: 806px;">';
            $html .= '<ul class="jPag-pages" style="width: 36px;">';
            $html .='<li><span  style="color: rgb(255, 255, 255); background-color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255);" onClick="' . $this->mudaPaginacao($url, $inicio . $this->reconstruiQueryString($inicio), $ajax, $janela) . '">Primeira</span></li>';
            if ($pagina > 1) {
                $html .='<li><span  style="color: rgb(255, 255, 255); background-color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255);" onClick="' . $this->mudaPaginacao($url, $prev . $this->reconstruiQueryString($prev), $ajax, $janela) . '">Anterior</span></li>';
            }
          
            for ($num = $maxLinks; $num <= $maxLinks + 5; $num++) {
                if ($num <= $totalPg) {
                    if ($num <> $pgAtual) {
                        $html .='<li><span ' . (($pgAtual < 1 and $num == 1) ? 'class="jPag-current"' : '') . ' style="color: rgb(255, 255, 255); background-color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255);"  onClick="' . $this->mudaPaginacao($url, $num . $this->reconstruiQueryString($num), $ajax, $janela) . '">' . $num . '</span></li>';
                    } else {
                        $html .= '<li><span  class="jPag-current" style="color: rgb(255, 255, 255); background-color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255);">' . $num . '</span></li>';
                    }
                }
            }
            if ($pagina < $totalPg) {
                $html .='<li><span  style="color: rgb(255, 255, 255); background-color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255);" onClick="' . $this->mudaPaginacao($url, $next . $this->reconstruiQueryString($next), $ajax, $janela) . '">Próxima</span></li>';
            }
            $html .='<li><span  style="color: rgb(255, 255, 255); background-color: rgb(255, 255, 255); border: 1px solid rgb(255, 255, 255);" onClick="' . $this->mudaPaginacao($url, $totalPg . $this->reconstruiQueryString($totalPg), $ajax, $janela) . '">Última</span></li>';
            $html .= '</ul>';
            $html .='</div>';

            $html .='</div>';

            return $html;
        }
    }

    public function filtro($url, $ajax = FALSE, $janela = 'container') {
        $aspas = "'";
        $html = '<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">';
        $html .= '<div class="dataTables_length" id="DataTables_Table_0_length"><label>Mostrar <select onchange="' . $this->offSet($url, 'this.value' . '+' . $aspas . $this->get('offset') . $aspas . '', $ajax, $janela) . '"  name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-control"><option value="50" ' . $this->selected(50, $this->get('offset')) . '>50</option><option ' . $this->selected(100, $this->get('offset')) . ' value="100">100</option><option ' . $this->selected(200, $this->get('offset')) . ' value="200">200</option><option ' . $this->selected(300, $this->get('offset')) . ' value="300">300</option></select> registros</label></div>';

        $html .= '<div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Pesquisar:<input type="search" name="search"  onkeypress="if (event.keyCode == 13 || event.which == 13) {
                                                                                                  ' . $this->busca($url, 'this.value', $ajax, $janela) . '
                    }" class="form-control" placeholder="Digite alguma coisa e aperte a tecla Enter" aria-controls="DataTables_Table_0"></label></div>';
        $html .= '</div>';
        return $html;
    }

    public function getPagina() {
        return $this->pagina;
    }

    public function getQtd() {
        return $this->qtd;
    }

    public function getInicio() {
        return $this->inicio;
    }

    public function getTotalGeral() {
        return $this->totalGeral;
    }

    public function getMudaPagina() {
        return $this->mudaPagina;
    }

    public function setPagina($pagina) {
        $this->pagina = $pagina;
        return $this;
    }

    public function setQtd($qtd) {
        $this->qtd = $qtd;
        return $this;
    }

    public function setInicio($inicio) {
        $this->inicio = $inicio;
        return $this;
    }

    public function setTotalGeral($totalGeral) {
        $this->totalGeral = $totalGeral;
        return $this;
    }

    public function setMudaPagina($mudaPagina) {
        $this->mudaPagina = $mudaPagina;
        return $this;
    }

}
