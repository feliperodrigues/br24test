<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
	CONST COMPANY_TYPE = [
		'Cliente' => 'CUSTOMER',
		'Fornecedor' => 'SUPPLIER',
		'Concorrência' => 'COMPETITOR',
		'Parceiro' => 'PARTNER',
		'Outro' => 'OTHER'
	];

	CONST INDUSTRY = [
		'Tecnologia da Informação' => 'IT',
		'Telecomunicação' => 'TELECOM',
		'Fabricação' => 'MANUFACTURING',
		'Serviços Bancários' => 'BANKING',
		'Consultoria' => 'CONSULTING',
		'Finanças' => 'FINANCE',
		'Governo' => 'GOVERNMENT',
		'Entregas' => 'DELIVERY',
		'Entreterimento' => 'ENTERTAINMENT',
		'Sem fins lucrativos' => 'NOTPROFIT',
		'Outro' => 'OTHER'
	];

	CONST PHONE_TYPE = [
		'Comercial' => 'WORK',
		'Celular' => 'MOBILE',
		'Fax' => 'FAX',
		'Residencial' => 'HOME',
		'Pager' => 'PAGER',
		'Outro' => 'OTHER'
	];

	CONST EMPLOYEES = [
		'Menos de 50' => 'EMPLOYEES_1',
		'50 a 250' => 'EMPLOYEES_2',
		'250 a 500' => 'EMPLOYEES_3',
		'Mais de 500' => 'EMPLOYEES_4'
	];

	CONST CURRENCY = [
		'Real Brasileiro' => 'BRL',
		'Dólar' => 'USD',
		'Euro' => 'EUR',
		'Yuan Chinês' => 'CNY',
		'Rupia Indiana' => 'INR'
	];
}
