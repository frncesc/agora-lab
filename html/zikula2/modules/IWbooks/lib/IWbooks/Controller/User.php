<?php

class IWbooks_Controller_User extends Zikula_AbstractController {

    public function postInitialize() {
        $this->view->setCaching(false);
    }

    public function main() {
        if (!SecurityUtil::checkPermission('IWbooks::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

        // Return the output that has been generated by this function
        return $this->view->fetch('IWbooks_user_main.htm');
    }

    public function view() {

        if (!SecurityUtil::checkPermission('IWbooks::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

        $etapa = '';
        $nivell = '';
        
        include_once('modules/IWbooks/fpdf153/fpdf.php');

        if (FormUtil::getPassedValue('pdf') != '') {
            $any = FormUtil::getPassedValue('curs');
            $etapa = FormUtil::getPassedValue('etapa');
            $materia = FormUtil::getPassedValue('materia');
            $nivell = FormUtil::getPassedValue('nivell');
            $lectura = FormUtil::getPassedValue('lectura');


            $file = self::generapdf(array('any' => $any,
                'materia' => $materia,
                'etapa' => $etapa,
                'nivell' => $nivell,
                'lectura' => $lectura));
        }


        $view = Zikula_View::getInstance('IWbooks');

        if (FormUtil::getPassedValue('curs') != "") {
            $any = FormUtil::getPassedValue('curs');
            $etapa = FormUtil::getPassedValue('etapa');
            $nivell = FormUtil::getPassedValue('nivell');
            $text = FormUtil::getPassedValue('text');
            $lectura = FormUtil::getPassedValue('lectura');
            $materia = FormUtil::getPassedValue('materia');

            $view->assign('cursselec', $any);
            $view->assign('etapaselec', $etapa);
            $view->assign('nivellselec', $nivell);
            $view->assign('textselec', $text);
            $view->assign('lecturaselec', $lectura);
            $view->assign('materiaselec', $materia);

            $view->assign('mostra', 1);
            $view->assign('cursacad', ModUtil::apiFunc('IWbooks', 'user', 'cursacad', array('any' => $any)));
            $view->assign('nivell_abre', ModUtil::apiFunc('IWbooks', 'user', 'reble', array('nivell' => $nivell)));
            $view->assign('mostra_pla', " | " . ModUtil::apiFunc('IWbooks', 'user', 'descriplans', array('etapa' => $etapa)));

            $mostra_mat = ModUtil::apiFunc('IWbooks', 'user', 'nommateria', array('codi_mat' => $materia));
            if ($materia == "TOT") {
                $view->assign('mostra_mat', " | Totes les matèries");
            } else {
                $view->assign('mostra_mat', " | " . $mostra_mat);
            }

            $view->assign('lectura', $lectura);
        } else {
            $any = ModUtil::getVar('IWbooks', 'any');
            //	$etapa = 'TOT';
            // 	$nivell = '';
            $text = 0;
            $lectura = 0;
            $materia = 'TOT';

            $view->assign('mostra', 0);
            $view->assign('cursselec', $any);
            $view->assign('etapaselec', $etapa);
            $view->assign('nivellselec', $nivell);
            $view->assign('materiaselec', $materia);
            $view->assign('lecturaselec', $lectura);
        }

        $startnum = (int) FormUtil::getPassedValue('startnum', 0) - 1;

        //$view = Zikula_View::getInstance('IWbooks');

        $aanys = ModUtil::apiFunc('IWbooks', 'user', 'anys');
        asort($aanys);
        $view->assign('aanys', $aanys);

        $aplans = ModUtil::apiFunc('IWbooks', 'user', 'plans', array('tots' => false));
        // array_unshift($aplans['TOT'], 'Tots'));
        $view->assign('aplans', $aplans);

        $anivells = ModUtil::apiFunc('IWbooks', 'user', 'nivells', array('blanc' => false));
        $view->assign('anivells', $anivells);

        $materies = ModUtil::apiFunc('IWbooks', 'user', 'materies', array('tots' => true));

        $amateries = array('TOT' => $this->__('All'));
        foreach ($materies as $materia1) {
            $amateries[$materia1['codi_mat']] = $materia1['materia'];
        }

        $view->assign('amateries', $amateries);

        $items = ModUtil::apiFunc('IWbooks', 'user', 'getall', array('startnum' => $startnum,
                    'numitems' => ModUtil::getVar('IWbooks', 'itemsperpage'),
                    'flag' => 'user',
                    'any' => $any,
                    'etapa' => $etapa,
                    'nivell' => $nivell,
                    'lectura' => $lectura,
                    'materia' => $materia));

        foreach ($items as $key => $item) {
            if ($items[$key]['lectura'] == 1) {
                $items[$key]['lectura'] = "Sí";
            } else {
                $items[$key]['lectura'] = "No";
            }

            if ($items[$key]['optativa'] == 1) {
                $items[$key]['optativa'] = "Sí";
            } else {
                $items[$key]['optativa'] = "No";
            }

            if ($items[$key]['materials'] != "") {
                $items[$key]['materials'] = "x";
            } else {
                $items[$key]['materials'] = "-";
            }

            if (SecurityUtil::checkPermission('IWbooks::', "$item[titol]::$item[tid]", ACCESS_READ)) {
                $options = array();
                if (SecurityUtil::checkPermission('IWbooks::', "$item[titol]::$item[tid]", ACCESS_EDIT)) {
                    $options[] = array('url' => ModUtil::url('IWbooks', 'admin', 'modify', array('tid' => $item['tid'])),
                        'image' => 'xedit.gif',
                        'title' => $this->__('Edit'));
                    if (SecurityUtil::checkPermission('IWbooks::', "$item[titol]::$item[tid]", ACCESS_DELETE)) {
                        $options[] = array('url' => ModUtil::url('IWbooks', 'admin', 'delete', array('tid' => $item['tid'])),
                            'image' => '14_layer_deletelayer.gif',
                            'title' => $this->__('Delete'));
                    }
                }

                $items[$key]['options'] = $options;
                $items[$key]['codi_mat'] = ModUtil::apiFunc('IWbooks', 'user', 'nommateria', array('codi_mat' => $item['codi_mat']));
                $items[$key]['titol'] = "<a href=\"" . ModUtil::url('IWbooks', 'user', 'display', array('tid' => $item['tid'], 'etapa' => $etapa)) . "\">" . $items[$key]['titol'] . "</a>";
            }
        }

        $view->assign('IWbooksitems', $items);

        $numitems = ModUtil::apiFunc('IWbooks', 'user', 'countitemsselect', array('any' => $any,
                    'etapa' => $etapa,
                    'nivell' => $nivell,
                    'materia' => $materia,
                    'lectura' => $lectura));

        $view->assign('pager', array('numitems' => $numitems,
            'itemsperpage' => ModUtil::getVar('IWbooks', 'itemsperpage')));

        return $view->fetch('IWbooks_user_view.htm');
    }

    public function display() {

        if (!SecurityUtil::checkPermission('IWbooks::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

        $tid = FormUtil::getPassedValue('tid');
        $etapa = FormUtil::getPassedValue('etapa');

        $view = Zikula_View::getInstance('IWbooks');

        $item = ModUtil::apiFunc('IWbooks', 'user', 'get', array('tid' => $tid));

        $view->assign('materia', ModUtil::apiFunc('IWbooks', 'user', 'nommateria', array('codi_mat' => $item['codi_mat'])));

        $item['etapa'] = ModUtil::apiFunc('IWbooks', 'user', 'descriplans', array('etapa' => $etapa));
        //  $item['nivell'] = ModUtil::apiFunc('IWbooks', 'user', 'reble', array('nivell' => $item['nivell']));
        $item['nivell'] = ModUtil::apiFunc('IWbooks', 'user', 'descrinivells', array('nivell' => $item['nivell']));

        if ($item['optativa'] == 1) {
            $item['optativa'] = "Sí";
        } else {
            $item['optativa'] = "No";
        }

        if ($item['lectura'] == 1) {
            $item['lectura'] = "Sí";
        } else {
            $item['lectura'] = "No";
        }
        $view->assign('itembook', $item);
        $view->assign('mostra', 1);

        return $view->fetch('IWbooks_user_display.htm');
    }

    /**
     * Get a file from a server folder even it is out of the public html directory
     * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
     * @param:	name of the file that have to be gotten
     * @return:	The file information
     */
    public function getFile($args) {
        // File name with the path
        $fileName = FormUtil::getPassedValue('fileName', isset($args['fileName']) ? $args['fileName'] : 0, 'GET');

        // Security check
        if (!SecurityUtil::checkPermission('IWbooks::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }
        $sv = ModUtil::func('IWmain', 'user', 'genSecurityValue');
        return ModUtil::func('IWmain', 'user', 'getFile', array('fileName' => $fileName,
                    'sv' => $sv));
    }

    function generapdf($args) {
        require_once(ModUtil::getVar('IWbooks', 'fpdf') . 'fpdf.php');
        require_once(ModUtil::getModuleBaseDir('IWbooks') . '/IWbooks/pnfpdf.php');

        $any = FormUtil::getPassedValue('curs');
        $etapa = FormUtil::getPassedValue('etapa');
        $materia = FormUtil::getPassedValue('materia');
        $nivell = FormUtil::getPassedValue('nivell');
        $lectura = FormUtil::getPassedValue('lectura');

        $dir = ModUtil::getVar('IWmain', 'documentRoot') . "/" . ModUtil::getVar('IWmain', 'tempFolder') . "/";
        // Netegem els fitxers temporals amb X segons d'antiguitat
        //self::NetejaFitxers($dir);

        $file = $dir . "tmp" . date('h' . 'm' . 's' . 'd') . ".pdf";

        extract($args);

        $cursacad = ModUtil::apiFunc('IWbooks', 'user', 'cursacad', array('any' => $any));
        $nivell_abre = ModUtil::apiFunc('IWbooks', 'user', 'reble', array('nivell' => $nivell));

        $items = ModUtil::apiFunc('IWbooks', 'user', 'getall', array('startnum' => $startnum,
                    'any' => $any,
                    'etapa' => $etapa,
                    'nivell' => $nivell,
                    'text' => $text,
                    'lectura' => $lectura,
                    'materia' => $materia,
                    'flag' => 'user',
                    'numitems' => 1000));

        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->Open();

        // Definir marges: esquerra i superior
        $marge_esq = 16;
        $marge_sup = 20;
        $pdf->SetMargins($marge_esq, $marge_sup);
        //  $pdf->SetMargins(25,20);
        $pdf->AddPage();


        $alt = ModUtil::getVar('IWbooks', 'mida_font') / 2; //5;
        $salt = ModUtil::getVar('IWbooks', 'mida_font') / 2; //5;
        $fita_lect = 0;   // marca de t�tol llibres de lectura
        $fita_opt = 0;   // marca de t�tol llibres d'optativa
        $fita_mat = 0;   // marca de t�tol de materisls


        $llis_mat = ModUtil::getVar('IWbooks', 'llistar_materials');
        $mida_font = ModUtil::getVar('IWbooks', 'mida_font');
        $mida_font_tit = $mida_font + 1;

        if (count($items) == 0) {
            $pdf->Write($alt, utf8_decode($this->__('There aren\'t books for your selection'))); // No hi ha llibres amb l'opció sol·licitada
            $pdf->Output($file);
            System::redirect(ModUtil::func('IWbooks', 'user', 'getFile', array('fileName' => str_replace(ModUtil::getVar('IWmain', 'documentRoot') . "/", '', $file))));
            return $file;
        }

        $mostra_pla = ModUtil::apiFunc('IWbooks', 'user', 'descriplans', array('etapa' => $etapa));

        $pdf->SetFont('Arial', 'B', 14);
        //        "Llistat de llibres"
        $pdf->MultiCell(0, 7, utf8_decode($this->__('List of books · Course') . $cursacad . " · " . $nivell_abre . " " . $mostra_pla), 1, 'C', 0);

        $pdf->Ln($salt - 1);
        $pdf->SetFont('Arial', 'BU', $mida_font_tit);
        $pdf->Write($alt, utf8_decode($this->__('Textbooks')));
        $pdf->Ln($salt + 1);

        foreach ($items as $item) {
            if ($item[lectura] == 1 and $fita_lect != 1) {
                $fita_lect = 1;
                $pdf->SetFont('Arial', 'BU', $mida_font_tit);
                $pdf->Ln($salt - 1);
                $pdf->Write($alt, utf8_decode($this->__('Reading Books')));
                $pdf->Ln($salt + 1);
            }

            if ($item[optativa] == 1 and $fita_opt != 1) {
                $fita_lect = 0;
                $fita_opt = 1;
                $pdf->SetFont('Arial', 'BU', 12);
                $pdf->Ln($salt + 3);
                $pdf->SetFont('Arial', 'B', $mida_font_tit);
                $pdf->MultiCell(0, $alt + 1, utf8_decode($this->__('Optional subjects')), 1, 'C', 0);
                $pdf->Ln(2);
                $pdf->SetFont('Arial', 'I', $mida_font_tit - 1);
                $pdf->Write($alt, utf8_decode("ATENCIÓ: Només per a l'alumnat que triï aquestes matèries"));
                $pdf->SetFont('Arial', 'BU', $mida_font_tit);
                $pdf->Ln($salt + 2);

                if ($item[lectura] == 1) {
                    $fita_lect = 1;
                    $pdf->Write($alt, utf8_decode($this->__('Reading Books')));
                    $pdf->Ln($salt + 1);
                } else {
                    $pdf->Write($alt, utf8_decode($this->__('Textbooks')));
                    $pdf->Ln($salt + 1);
                }
            }

            if ($item['optativa'] == 1)
                $optativa = '**';

            $nommateria = utf8_decode(ModUtil::apiFunc('IWbooks', 'user', 'nommateria', array('codi_mat' => $item['codi_mat'])));

            if (substr($item['codi_mat'], 0, 2) != "AA") {

                $pdf->SetFont('Arial', '', $mida_font);

                $pdf->Write($alt, chr(149) . " " . $optativa . " " . $nommateria . " -  ");

                $m_autor = "";
                if ($item[autor] != "")
                    $m_autor = utf8_decode($item[autor]) . ", ";

                $pdf->Write($alt, $m_autor);
                $pdf->SetFont('Arial', 'I', $mida_font);
                $pdf->Write($alt, utf8_decode($item['titol']));
                $pdf->SetFont('Arial', '', $mida_font);
                $m_aval = '';

                if ($item[avaluacio] != "")
                    $m_aval = ", (" . $item['avaluacio'] . utf8_decode($this->__('to avaluation')) . ")";

                $m_publi = "";
                if ($item[any_publi] != "")
                    $m_publi = ", " . $item['any_publi'];

                $m_isbn = "";
                if ($item[isbn] != "")
                    $m_isbn = ", (ISBN: " . $item['isbn'] . ")";

                $pdf->Write($alt, ", " . utf8_decode($item['editorial']) . $m_publi . $m_aval . $m_isbn);


                $m_obs = "";
                if ($item['observacions'] != "")
                    $m_obs = " -- (" . utf8_decode($item['observacions']) . ")";

                $pdf->SetFont('Arial', 'I', $mida_font);
                $pdf->Write($alt, $m_obs);

                $pdf->Ln($salt);
            }

            // Omplim array amb els materials, per imprimir-los despr�s
            if ($item[materials] != "") {
                $amaterials[] = array('nom_mat' => $nommateria,
                    'materials' => $item['materials'],
                    'etapa' => $item['etapa'],
                    'optativa' => $optativa);
            }
        }


        // Llistem materials
        foreach ($amaterials as $row) {
            if ($llis_mat == "1") {
                if ($llis_mat == 1 and $fita_mat != 1) {
                    $fita_mat = 1;
                    $pdf->SetFont('Arial', 'B', $mida_font_tit);
                    $pdf->Ln($salt + 2);
                    $pdf->MultiCell(0, $alt + 1, utf8_decode($this->__('Materials')), 1, 'C', 0);
                    $pdf->Ln($salt);
                }

                $pdf->SetFont('Arial', 'B', $mida_font);
                $pdf->Write($alt, chr(149) . " " . $row[optativa] . " " . $row[nom_mat]);
                $pdf->Ln($salt);
                $pdf->SetFont('Arial', '', $mida_font);
                $posicio = $pdf->GetX();
                $pdf->SetX($posicio + 8);
                $pdf->Multicell(0, $alt, utf8_decode($row[materials]));
                $pdf->SetX($posicio);
                $pdf->Ln($salt - 2);
            }
        }

        $pdf->Output($file);
        $pdf->Output();

        System::redirect(ModUtil::func('IWbooks', 'user', 'getFile', array('fileName' => str_replace(ModUtil::getVar('IWmain', 'documentRoot') . "/", '', $file))));

        return $file;
    }

}