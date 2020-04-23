<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paginacao {

    private $pagina;
    private $qtd;
    private $inicio;
    private $totalGeral = 0;
    private $mudaPagina;

    public function initialize() {
        $this->setPagina(($this->get('p') > 0) ? (int) $this->get('p') : 1);
        $this->setQtd(1);
        $this->Limite(50);
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
            return "loadingPaginacao('" . $this->baseUrl() . '/' . $this->uriString($url) . $link . "', '" . $janela . "');";
        }

        return "mudaPagina('" . $this->uriString($url) . $link . "');";
    }

    public function offSet($url, $link, $ajax = FALSE, $janela = 'container') {
        if ($ajax === TRUE) {
            return "loadingPaginacao('" . $this->baseUrl() . '/' . $this->urlString($url) . "'+" . $link . ", '" . $janela . "');";
        }

        return "mudaPagina('" . $this->urlString($url) . "'+" . $link . ");";
    }

    public function busca($url, $link, $ajax = FALSE, $janela = 'container') {
        if ($ajax === TRUE) {
            return "loadingPaginacao('" . $this->baseUrl() . '/' . $this->uriStringBusca($url) . "'+" . $link . ", '" . $janela . "');";
        }

        return "mudaPagina('" . $this->uriStringBusca($url) . "'+" . $link . ");";
    }

    public function reconstruiQueryString($valoresQueryString, $pagina = FALSE) {

        if (!empty($_SERVER['QUERY_STRING'])) {

            $partes = explode("&", $_SERVER['QUERY_STRING']);

            $novasPartes = array();
            $outrasPartes = array();

            foreach ($partes as $val) {
                if (stristr($val, $valoresQueryString) === false and stristr($val, $this->get('path')) === false) {

                    array_push($novasPartes, $val);
                }
            }
            if ($novasPartes) {
                foreach ($novasPartes as $val) {

                    if (stristr($val, $pagina) === false and stristr($val, $this->get('path')) === false) {

                        array_push($outrasPartes, $val);
                    }
                }
            }


            if (count($outrasPartes) != 0) {

                $queryString = "&" . implode("&", $outrasPartes);
            } else {

                return false;
            }

            return $queryString; // nova string criada
        } else {

            return false;
        }
    }

    //methodo para mostrar a paginação
    public function exibirPaginacao($pagina, $totalPg, $url, $totalRegistro = FALSE, $ajax = FALSE, $janela = 'container') {
        $prev = $pagina - 1;
        $next = $pagina + 1;
        $maxLinks = $this->getPagina();
        $inicio = 1;
        ?>

        <!-- Pagination -->
        <?php if ($totalPg > 1) { ?>
            <div style="float: left; "><?php echo 'Mostrando ' . $this->getQtd() . ' de ' . $totalRegistro . ' registros'; ?></div>
            <nav aria-label="Page navigation" class="text-center">
                <ul class="pagination" >

                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onClick="<?php echo $this->mudaPaginacao($url, $inicio . $this->reconstruiQueryString('p'), $ajax, $janela); ?>" aria-label="Previous">
                            <span aria-hidden="true">Primeira</span>
                        </a>
                        <?php if ($pagina > 1) { ?>
                        <a class="page-link" href="javascript:void(0);" onClick="<?php echo $this->mudaPaginacao($url, $prev . $this->reconstruiQueryString('p'), $ajax, $janela); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                        <?php } ?>
                    </li>



                    <?php
                    for ($num = $maxLinks; $num <= $maxLinks + 5; $num++) {
                        ?>
                        <?php if ($num <= $totalPg) { ?>
                            <?php if ($num <> $this->get('p')) { ?>
                                <li class="page-item <?php echo ($this->get('p') < 1 and $num == 1) ? 'active' : ''; ?>"><a href="javascript:void(0);" class="page-link"  onClick="<?php echo $this->mudaPaginacao($url, $num . $this->reconstruiQueryString('p'), $ajax, $janela); ?>"><?php echo $num; ?></a></li>
                            <?php } else { ?>
                                <li class="page-item active"><a class="page-link"><?php echo $num; ?></a></li>
                            <?php } ?>
                        <?php } ?>

                    <?php } ?>


                    <li class="page-item">
                        <?php if ($pagina < $totalPg) { ?>
                        <a class="page-link" onClick="<?php echo $this->mudaPaginacao($url, $next . $this->reconstruiQueryString('p'), $ajax, $janela); ?>" href="javascript:void(0);" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                        <?php } ?>
                        <a class="page-link" onClick="<?php echo $this->mudaPaginacao($url, $totalPg . $this->reconstruiQueryString('p'), $ajax, $janela); ?>" href="javascript:void(0);" aria-label="Next">
                            <span aria-hidden="true">Última</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php } ?>
        <!-- // Pagination END -->

        <?php
    }

    public function filtro($url, $ajax = FALSE, $janela = 'container') {
        $aspas = "'";
        ?>

        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
            <div class="dataTables_length" id="DataTables_Table_0_length"><label>Mostrar <select onchange="<?php echo $this->offSet($url, 'this.value' . '+' . $aspas . $this->get('offset') . $aspas . '', $ajax, $janela); ?>"  name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-control"><option value="50" <?php echo $this->selected(50, $this->get('offset')); ?>>50</option><option <?php echo $this->selected(100, $this->get('offset')); ?> value="100">100</option><option <?php echo $this->selected(200, $this->get('offset')); ?> value="200">200</option><option <?php echo $this->selected(300, $this->get('offset')); ?> value="300">300</option></select> registros</label></div>

            <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Pesquisar:<input type="search" name="search"  onkeypress="if (event.keyCode == 13 || event.which == 13) {
                    <?php echo $this->busca($url, 'this.value', $ajax, $janela); ?>
                    }" class="form-control" placeholder="Digite alguma coisa e aperte a tecla Enter" aria-controls="DataTables_Table_0"></label></div>
        </div>
        <?php
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
