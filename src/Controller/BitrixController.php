<?php
namespace App\Controller;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

use Unirest;

class BitrixController extends AbstractController
{

	private $obB24App;

	/**
	 * @Route("/connect/bitrix")
	 */
	public function connectAction(Request $request)
	{
		$session = new Session();

		$session->set('domain', $request->query->get('DOMAIN'));
		$session->set('member_id', $request->request->get('member_id'));
		$session->set('access_token', $request->request->get('AUTH_ID'));
		$session->set('refresh_token', $request->request->get('REFRESH_ID'));

		return $this->redirectToRoute('bitrix_company_list');
		//return new Response('<html><body>'.var_dump($wtf).'</body></html>');
	}


	/**
	 * @Route("/company", name="bitrix_company_list")
	 *
	 * @return Response
	 */
	public function companyListAction()
	{
		$session = new Session();
		$this->startBitrix();

		$company = new \Bitrix24\CRM\Company($this->obB24App);
		$companyList = $company->getList()['result'];

		return $this->render('crm/company/company-list.html.twig', ['companyList' => $companyList]);
	}

	/**
	 * @Route("/company/new", name="bitrix_company_new")
	 *
	 */
	public function companyFormAction(Request $request)
	{
		$session = new Session();
		$this->startBitrix();

		$form = $this->createFormBuilder()
			->add('TITLE', TextType::class, ['label' => 'Nome da Empresa'])
			->add('COMPANY_TYPE', ChoiceType::class, ['label' => 'Tipo', 'choices' => Company::COMPANY_TYPE])
			->add('REVENUE', NumberType::class, ['label' => 'Receita Anual', 'scale' => 2])
			->add('CURRENCY_ID', ChoiceType::class, ['label' => 'Moeda', 'choices' => Company::CURRENCY])
			->add('INDUSTRY', ChoiceType::class, [ 'label' => 'Tipo', 'choices' => Company::INDUSTRY ])
			->add('EMPLOYEES', ChoiceType::class, ['label' => 'Funcionários', 'choices' => Company::EMPLOYEES])
			->add('save', SubmitType::class, ['label' => 'Salvar'])
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$company = new \Bitrix24\CRM\Company($this->obB24App);
			$result = $company->add($form->getData());

			return $this->redirectToRoute('bitrix_company_list');
		}

		return $this->render('crm/company/company-form.html.twig', ['form' => $form->createView()]);
	}

	private function startBitrix()
	{
		$session = new Session();

		$this->obB24App = new \Bitrix24\Bitrix24(false);
		$this->obB24App->setDomain($session->get('domain'));
		$this->obB24App->setMemberId($session->get('member_id'));
		$this->obB24App->setAccessToken($session->get('access_token'));
		$this->obB24App->setRefreshToken($session->get('refresh_token'));
	}
}
