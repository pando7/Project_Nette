<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Models\BrandsFacade;
use Nette;


final class BrandPresenter extends Nette\Application\UI\Presenter
{
    private $brands;
    private $db;


    public function __construct(BrandsFacade $brands, Nette\Database\Explorer $db)
    {
        $this->brands = $brands;
        $this->db = $db;
    }

    // CALLING VIEW
    public function renderDefault(int $page = 1, ?int $itemCount = 3, ?string $sorting = null):void
    {
        $lastPage = 0;

        $brands = $this->brands->getBrands($sorting);

        $this->template->brands = $brands->page($page, $itemCount, $lastPage);

        $this->template->page = $page;
        $this->template->lastPage = $lastPage;
        $this->template->itemCount = $itemCount;
        $this->template->sorting = $sorting;
    }

    // CREATING BRAND FORM
    protected function createComponentBrandForm(): Nette\Application\UI\Form
    {
        $form = new Nette\Application\UI\Form();

        $form->addText('brandName', 'Jméno')->setRequired('Zadejte prosím jméno');
        $form->addText("countryCode", 'Kód krajiny')->setDefaultValue("SK")->setRequired('Zadejte prosím kód krajiny');
        $form->addInteger('tax', 'DPH')->setDefaultValue(20)->setRequired('Zadejte prosím DPH');
        $form->addHidden('brandId', null)->setHtmlId('brandId');
        $form->addSubmit("send", "Potvrdit změny")->setHtmlAttribute('class', "btn");

        $form->onSuccess[] = [$this, 'brandFormSucceeded'];

        return $form;
    }

    // BRAND FORM CALLBACK
    public function brandFormSucceeded(\stdClass $data): void
    {
        if($data->brandId == null)
        {
            $this->db->table('brands')->insert([
                'name' => $data->brandName,
                'countryCode' => $data->countryCode,
                'tax' => $data->tax
            ]);

            $this->flashMessage("Značka úspěšně přidána");
        }
        else
        {
            $this->db->table('brands')->where('id', $data->brandId)
                ->update([
                    'name' => $data->brandName,
                    'countryCode' => $data->countryCode,
                    'tax' => $data->tax
            ]);

            $this->flashMessage("Značka úspěšně updatnutá");
        }

        $this->redirect('this');
    }



    // BRAND DELETE HANDLER
    public function handleDelete():void
    {
        $brandId = $this->getHttpRequest()->getPost('deleteBrandId');

        $this->db->table('brands')->where('id', $brandId)->delete();

        $this->flashMessage('Značka byla úspěšně vymazána s id ' . $brandId);

        $this->redirect('this');
    }
}
