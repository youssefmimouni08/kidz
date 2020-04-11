<?php

namespace ClasseBundle\Controller;

use KidzyBundle\Entity\Classe;
use PhpOffice\PhpSpreadsheetBundle;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \PhpOffice\PhpSpreadsheet\Writer;
use \PhpOffice\PhpSpreadsheet\Reader;


/**
 * Classe controller.
 *
 */
class ClasseController extends Controller
{
    /**
     * Lists all classe entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $classes = $em->getRepository('KidzyBundle:Classe')->findAll();
        $spreadsheet = new Spreadsheet();
        // Get active sheet - it is also possible to retrieve a specific sheet
        $sheet = $spreadsheet->getActiveSheet();

        // Set cell name and merge cells
        $sheet->setCellValue('A1', 'liste des classes')->mergeCells('A1:D1');

        // Set column names
        $columnNames = [
            'id',
            'libele',
            'description',
        ];
        $columnLetter = 'A';
        foreach ($columnNames as $columnName) {
            // Allow to access AA column if needed and more
            $columnLetter++;
            $sheet->setCellValue($columnLetter.'2', $columnName);
        }

        // Add data for each column
        foreach ($classes as $i => $item){
            $columnValues = [


                ['azaeazra', 'Google Inc.', 'September 2, 2008'],


            ];}



        $i = 3; // Beginning row for active sheet
        foreach ($columnValues as $columnValue) {
            $columnLetter = 'A';
            foreach ($columnValue as $value) {
                $columnLetter++;
            $sheet->setCellValue($columnLetter.$i, $value);
        }
            $i++;
        }
        $webDirectory = $this->get('kernel')->getProjectDir() . '/web';
        $excelFilepath =  $webDirectory . '/testing.xlsx';
        $writerXlsx = $this->get('phpoffice.spreadsheet')->createWriter($spreadsheet, 'Xlsx');
        $writerXlsx->save($excelFilepath);
        //return $spreadsheet;
        return $this->render('@Classe/classe/index.html.twig', array(
            'classes' => $classes,
        ));
    }

    /**
     * Creates a new classe entity.
     *
     */
    public function newAction(Request $request)
    {


//        $webDirectory = $this->get('kernel')->getProjectDir() . '/web';
//        $excelFilepath =  $webDirectory . '/testing.xlsx';
//        $spreadsheet = $this->get('phpoffice.spreadsheet')->createSpreadsheet();
//        $spreadsheet->getActiveSheet()->setCellValue('A1', 'Hello world');
//
//        $writerXlsx = $this->get('phpoffice.spreadsheet')->createWriter($spreadsheet, 'Xlsx');
//        $writerXlsx->save($excelFilepath);
//        $readerXlsx  = $this->get('phpoffice.spreadsheet')->createReader('Xlsx');
//        $sheet = $readerXlsx->load($excelFilepath);
//        $data = $this->createDataFromSpreadsheet($sheet);

        $classe = new Classe();
        $form = $this->createForm('ClasseBundle\form\ClasseType', $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('classe_show', array('idClasse' => $classe->getIdclasse()));
        }

        return $this->render('@Classe/classe/new.html.twig', array(
            'classe' => $classe,
            'form' => $form->createView(),
        ));

    }

    /**
     * Finds and displays a classe entity.
     *
     */
    public function showAction(Classe $classe)
    {
        $deleteForm = $this->createDeleteForm($classe);

        return $this->render('@Classe/classe/show.html.twig', array(
            'classe' => $classe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing classe entity.
     *
     */
    public function editAction(Request $request, Classe $classe)
    {
        $deleteForm = $this->createDeleteForm($classe);
        $editForm = $this->createForm('ClasseBundle\form\ClasseType', $classe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classe_edit', array('idClasse' => $classe->getIdclasse()));
        }

        return $this->render('@Classe/classe/edit.html.twig', array(
            'classe' => $classe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a classe entity.
     *
     */
    public function deleteAction(Request $request, Classe $classe)
    {
        $form = $this->createDeleteForm($classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($classe);
            $em->flush();
        }

        return $this->redirectToRoute('classe_index');
    }

    /**
     * Creates a form to delete a classe entity.
     *
     * @param Classe $classe The classe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Classe $classe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('classe_delete', array('idClasse' => $classe->getIdclasse())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function excelCreate()
    {
        $spreadsheet = $this->get('phpspreadsheet')->createSpreadsheet();

    }
}
