<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Locação de Veículo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            padding: 40px 60px;
            background: #fff;
        }
        .header {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 30px;
            font-size: 14pt;
        }
        .section {
            margin-bottom: 15px;
            text-align: justify;
        }
        .section-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 10px;
            margin-top: 20px;
        }
        .clause {
            margin-bottom: 15px;
            text-align: justify;
        }
        .clause-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 8px;
        }
        .paragraph {
            margin-bottom: 10px;
            text-align: justify;
        }
        .bold {
            font-weight: bold;
        }
        .underline {
            text-decoration: underline;
        }
        .signatures {
            margin-top: 50px;
            page-break-inside: avoid;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .signature-row {
            margin-bottom: 40px;
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .signature-block {
            width: 45%;
            max-width: 320px;
            text-align: center;
            margin: 0 auto;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 5px;
        }
        .location-date {
            text-align: center;
            margin: 40px 0;
        }
        .witnesses {
            margin-top: 40px;
        }
        .documentHeader {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 15px;
        }
        .headerLogo {
            width: 100px;
            height: auto;
            flex-shrink: 0;
            object-fit: contain;
        }
        .headerTitles {
            flex: 1;
            text-align: center;
        }
        @media print {
            body {
                padding: 20px 40px;
            }
        }
    </style>
</head>
<body>
    <h1 class="header">CONTRATO DE LOCAÇÃO DE VEÍCULO POR PRAZO DETERMINADO</h1>
    <h3 class="header">Contrato Nº:</span> {{ $contract_id }}</h3>
    <div class="section">
        <p><span class="bold underline">LOCADOR</span>: IZI CAR LOCAÇÕES DE VEÍCULOS CNPJ: 54.379.584/0001-87, AV Liberdade 207B, bairro Passo da Areia, CEP 97010-270.</p>
    </div>
    <div class="section">
        <p><span class="bold underline">LOCATÁRIO</span>: {{ $motorista_nome }}, brasileiro, solteiro, @if(!empty($motorista_cnh))CNH nº {{ $motorista_cnh }}, @endif CPF {{ $motorista_documento }}, endereço {{ $motorista_rua }}, N {{ $motorista_numero }}, Bairro {{ $motorista_bairro }}, {{ $motorista_cidade }} CEP {{ $motorista_cep }}.</p>
    </div>
    <div class="section">
        <p><span class="bold underline">VEÍCULO</span>: O presente contrato tem como objeto único e exclusivo a Locação do automóvel com as seguintes informações: {{ $veiculo }}, ano de fabricação e modelo {{ $fabricacao_modelo }}, placa {{ $placa }}, CHASSI {{ $chassi }}, RENAVAM {{ $renavam }}.</p>
    </div>
    <div class="section">
        <p><span class="bold underline">PROPRIETÁRIO DO VEÍCULO</span>: {{ $proprietario_nome }}, CPF/CNPJ {{ $proprietario_documento }}.</p>
    </div>
    <div class="section">
        <p><span class="bold underline">PRAZO DO CONTRATO</span>: 30 (trinta dias), renovável automaticamente a cada 30 (trinta) dias, sucessivamente, enquanto convier às partes.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 1ª - DO OBJETO DO CONTRATO</p>
        <p>O presente contrato tem como objeto a locação do veículo acima caracterizado, mediante a remuneração DIÁRIA de R$ {{ $valor }} ({{ $valor_extenso }}), podendo ser utilizado pelo locatário durante as 24 horas do dia.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 2ª - DO PRAZO</p>
        <p>O presente contrato tem como objeto a locação do veículo acima caracterizado, mediante a remuneração DIÁRIA, devendo ser paga até às 23:59hrs, podendo ser utilizado pelo locatário durante as 24 horas do dia, por 30 (trinta dias), renovável automaticamente a cada 30 (trinta) dias, sucessivamente, enquanto convier às partes.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 3ª - DO USO</p>
        <p>O objeto deste contrato será utilizado exclusivamente pelo <strong>LOCATÁRIO</strong>, especialmente para utilização em plataformas (aplicativos) de passageiros, tais como: 99, uber, indrive e semelhantes.</p>
        <p class="paragraph"><strong>§1:</strong> Fica o <strong>LOCATÁRIO</strong> responsável por seguir as diretrizes e atender às exigências de credenciamento das referidas plataformas.</p>
        <p class="paragraph"><strong>§2:</strong> Não é permitida a utilização do veículo por terceiro, sob pena de rescisão contratual e multa no valor correspondente a 10 diárias de locação.</p>
        <p class="paragraph"><strong>§3:</strong> É vedada a utilização do veículo para transportar produtos ilícitos ou prática de ilícitos, sob pena de rescisão contratual, com o pagamento de multa no valor correspondente a 10 diárias de locação, sem prejuízo de ressarcimento de outras despesas que isso ocasionar para a <strong>LOCADORA</strong> ou proprietário do veículo.</p>
        <p class="paragraph"><strong>§4:</strong> O <strong>LOCATÁRIO</strong> não poderá sair com o veículo fora do perímetro urbano sem prévia autorização formal da <strong>LOCADORA</strong>. Se o fizer, estará violando o contrato.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 4ª - DO VALOR</p>
        <p>A título de contraprestação, o <strong>LOCATÁRIO</strong> pagará ao <strong>LOCADOR</strong> o valor da diária de R$ {{ $valor }} ({{ $valor_extenso }}) durante a vigência do contrato.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 5ª - DO PAGAMENTO E DA QUEBRA DO CONTRATO POR INADIMPLEMENTO</p>
        <p>O pagamento do aluguel será feito diariamente. Na sede da locadora, poderá ser pago em dinheiro, por pix chave: CNPJ <strong>54.379.584/0001-87</strong>, sob pena de resolução do contrato, valendo o comprovante como quitação da obrigação. O não pagamento da diária por três dias consecutivos ocasionará o bloqueio imediato do veículo, bem como seu recolhimento ao <strong>LOCADOR</strong> e o <strong>LOCATÁRIO</strong> responderá por apropriação indevida do bem, de acordo com o disposto no artigo 168 do Código Penal, quebra do contrato, presente na Cláusula 10ª §3.</p>
        <p class="paragraph"><strong>§1:</strong> <strong>O valor pago será referente aos dias de locação e o depósito/ PIX do valor devido servirá como quitação dos débitos anteriores referentes às diárias.</strong></p>
        <p class="paragraph"><strong>§2:</strong> Em caso de inadimplemento, indicará a quebra de contrato, devendo ao <strong>LOCATÁRIO</strong> ressarcir todas as obrigações para com a <strong>LOCADORA</strong>, multas, av. diárias, sem prejuízo do disposto na Cláusula 11ª, sob pena da perda da caução e Fundo do Locatário.</p>
        <p class="paragraph"><strong>§3:</strong> Fica acordado entre as partes que na hipótese de não pagamento da locação do veículo por parte do <strong>LOCATÁRIO</strong>, o atraso de pagamento igual ou superior a 3 (três) dias acarretará na imediata retomada (posse do automóvel por parte da <strong>LOCADORA</strong>), perda da caução e imediata cobrança da multa de rescisão estipulada neste contrato.</p>
        <p class="paragraph"><strong>§4:</strong> <strong>Na hipótese de atraso do pagamento da diária serão cobrados juros de 2% ao dia sobre o valor das diárias em atraso.</strong></p>
        <p class="paragraph"><strong>§5:</strong> Fica o <strong>LOCATÁRIO</strong> ciente de que estando com 03 (três) ou mais diárias em atraso o veículo poderá ser bloqueado e retomado a qualquer tempo por parte da <strong>LOCADORA</strong>. Não onerando a <strong>LOCADORA</strong> de qualquer transtorno ou custas devido ao bloqueio do veículo.</p>
        <p class="paragraph"><strong>§6:</strong> Em caso de inadimplência do <strong>LOCATÁRIO</strong> por 01 (um) dia ou mais, o <strong>LOCADOR</strong> poderá realizar o bloqueio imediato do veículo, por meio de sistema de rastreamento, sem necessidade de aviso prévio, até a regularização integral dos débitos.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 6ª - DA GARANTIA E DO FUNDO DO LOCATÁRIO</p>
        <p>Como garantia do presente contrato, o <strong>LOCATÁRIO</strong> pagou a quantia de R$ {{ $caucao }} ({{ $caucao_extenso }}) o qual equivale à parte do valor da franquia de seguro do veículo, objeto do presente instrumento.</p>
        <p class="paragraph"><strong>§1:</strong> Se o <strong>LOCATÁRIO</strong> não restituir o veículo na data estipulada contratualmente, sem a realização de aditivo contratual, implicará a perda da caução, além de responder pelos danos que o automóvel vier a sofrer mesmo se provenientes de caso fortuito ou força maior, sem prejuízo do pagamento das diárias até a data da entrega do veículo à <strong>LOCADORA</strong>.</p>
        <p class="paragraph"><strong>§2:</strong> A caução será devolvida em até 30 dias úteis, após final da locação, ou de haver valores que sejam devidos pelo locatário, por aluguel, multas, avarias os possíveis débitos serão descontados da caução.</p>
        <p class="paragraph"><strong>§3:</strong> Caso o <strong>LOCATÁRIO</strong> resolva devolver o veículo objeto deste contrato antes do prazo inicial de 30 dias, o valor acumulado de caução referente ao tempo em que ficou com o carro não será devolvido a título de quebra de contrato.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 7ª - DAS CONDIÇÕES DO VEÍCULO</p>
        <p>O <strong>LOCATÁRIO</strong> reconhece que vistoriou o veículo e que deverá devolvê-lo à <strong>LOCADORA</strong> nas mesmas condições em que o recebeu, ou seja, em perfeito estado de uso, com detalhes incluídos na FICHA DE VISTORIA e ou fotografias que fará parte do presente instrumento, sem quaisquer avarias, respondendo pelos danos ou prejuízos causados, podendo a <strong>LOCADORA</strong> submetê-lo a exames por mecânico de sua confiança. O <strong>LOCATÁRIO</strong> assume responsabilidade por danos ou prejuízos que vier a causar.</p>
        <p class="paragraph"><strong>§1:</strong> Quando as partes resolverem rescindir o contrato o <strong>LOCATÁRIO</strong> fica responsável por devolver o veículo com a gasolina no mesmo nível em que recebeu, da qual será tirada uma foto do marcador no dia em que o veículo for entregue ao locatário. Caso o <strong>LOCATÁRIO</strong> não devolva no mesmo nível, a <strong>LOCADORA</strong> efetuará o preenchimento do combustível e o valor será descontado em dobro da caução.</p>
        <p class="paragraph"><strong>§2:</strong> É terminantemente proibido fumar no veículo e a responsabilidade de passageiros de o fazerem cabe exclusivamente ao <strong>LOCATÁRIO</strong>, que poderá arcar com a taxa de higienização de fumaça no valor de R$300,00 (trezentos reais).</p>
        <p class="paragraph"><strong>§3:</strong> A Locadora realizará a entrega do veículo ao <strong>LOCATÁRIO</strong> devidamente limpo e higienizado. A falta da limpeza completa no momento da entrega ensejará a cobrança da taxa de limpeza no valor de R$120,00 (cento e vinte reais).</p>
        <p class="paragraph"><strong>§4:</strong> Os valores constantes nos parágrafos 1 e 2 da presente Cláusula serão descontados da caução, no momento da devolução do veículo.</p>
        <p class="paragraph"><strong>§5:</strong> O <strong>LOCATÁRIO</strong> poderá solicitar a troca do veículo durante a vigência do contrato, mediante o pagamento de uma taxa única no valor de R$ 100,00 (cem reais). A troca será realizada de acordo com a disponibilidade de veículos na frota da <strong>LOCADORA</strong> e será formalizada mediante novo contrato.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 8ª - DAS RESPONSABILIDADES</p>
        <p>O <strong>LOCATÁRIO</strong> assume exclusivamente a responsabilidade civil, criminal e administrativa por todos os fatos ou danos que vierem a ocorrer com o veículo locado durante a vigência da locação. Responsabiliza-se pelo valor pecuniário e pontuação decorrentes de infrações de trânsito por autuações no período da locação, inclusive taxas cartoriais e de correio.</p>
        <p class="paragraph"><strong>§1:</strong> Com a expedição de auto de infração o <strong>LOCATÁRIO</strong> compromete-se em assinar a notificação de autuação reconhecendo-se como condutor/infrator nas infrações cometidas na vigência do contrato, devendo para tal disponibilizar a documentação exigida e no prazo indicado pelo Departamento de Trânsito, ainda que a notificação seja remetida após o término do lapso temporal contratado.</p>
        <p class="paragraph"><strong>§2:</strong> O <strong>LOCATÁRIO</strong> deverá arcar com o reparo de todos os danos porventura constatados no veículo no prazo de até 10 (dez) dias da data de sua devolução, ficando a cargo da <strong>LOCADORA</strong> escolher as peças e os profissionais que realizarão o conserto, independentemente do valor, sem prejuízo do pagamento à <strong>LOCADORA</strong>, a título de ressarcimento por prejuízo causado ao <strong>LOCADOR</strong>.</p>
        <p class="paragraph"><strong>§3:</strong> É estritamente proibido qualquer modificação, conserto ou troca de peças ou itens do veículo sem aviso prévio e autorização formalizada da <strong>LOCADORA</strong>, e se constatada alguma irregularidade neste sentido o <strong>LOCATÁRIO</strong> se responsabiliza pelo custo de reparação dos danos ocasionados, assim como pelo refazimento de conserto e troca de peças ou itens providenciado pela <strong>LOCADORA</strong>.</p>
        <p class="paragraph"><strong>§4:</strong> Será apresentado de forma online (através do endereço posdetran.rs.gov.br) as multas que venham a incidir sobre o veículo locado no prazo da locação. O <strong>LOCATÁRIO</strong> terá o prazo de 24h para confirmação através do e-mail ou telefone cadastrado no Detran sua responsabilidade. Caso o <strong>LOCATÁRIO</strong> não consiga acessar "gov.br" ou e-mail cadastrado ao DETRAN, a solicitação de real condutor será realizada em documento impresso da maneira tradicional no mesmo prazo estipulado de forma online. As multas deverão ser pagas imediatamente após sua identificação.</p>
        <p class="paragraph"><strong>§5:</strong> O <strong>LOCATÁRIO</strong> obriga-se a encaminhar ao <strong>LOCADOR</strong>, toda segunda-feira, a informação da quilometragem atual do veículo, por meio dos canais indicados, com a finalidade de controle de manutenção preventiva e garantia do bom funcionamento do bem locado. O não envio da quilometragem, após solicitação, autoriza o <strong>LOCADOR</strong> a realizar o bloqueio preventivo do veículo, por meio de sistema de rastreamento, sem aviso prévio, até a regularização da obrigação, não configurando abuso de direito.</p>
        <p class="paragraph"><strong>§6:</strong> A <strong>LOCADORA</strong> se compromete de resolver em tempo hábil, quando necessárias as manutenções e consertos inerentes ao desgaste natural ou troca de fluidos que venham a incidir sobre o veículo durante a vigência do contrato. Destaca-se que troca de lâmpada, pneu furado, ou avarias ocorridas pelo mau uso do veículo são de inteira responsabilidade do <strong>LOCATÁRIO</strong>.</p>
        <p class="paragraph"><strong>§7:</strong> Quando o veículo passar por manutenção que ocasione impossibilidade de utilização, desde que esta manutenção não tenha sido provocada pelo <strong>LOCATÁRIO</strong> é facultado ao mesmo o desconto DA FRAÇÃO DO DIA em que o veículo não foi utilizado ou utilização de outro veículo disponível, de qualidade similar, ofertado pela <strong>LOCADORA</strong>, se houver.</p>
        <p class="paragraph"><strong>§8:</strong> A devolução da caução somente ocorrerá após o decurso do prazo de 30 dias úteis a fim de resguardar o direito de retenção quanto às multas ou prejuízos que se apresentem supervenientes ao prazo de validade do contrato.</p>
        <p class="paragraph"><strong>§9:</strong> O <strong>LOCATÁRIO</strong> compromete-se em aceitar a indicação de "principal condutor" do veículo objeto deste contrato em no máximo 24 horas a contar da assinatura do mesmo, sob pena de rescisão contratual e perda de caução caso não o faça.</p>
        <p class="paragraph"><strong>§10:</strong> Caso o <strong>LOCATÁRIO</strong> não tenha acesso ao seu aplicativo do "GOV.BR" para fazer o aceite como "Principal Condutor" do veículo, será dado ao mesmo o prazo de 4 dias úteis para que regularize o seu acesso ao aplicativo e possa fazer o aceite. Caso o mesmo não o faça estará violando o presente contrato e estará sujeito a bloqueio do veículo e rescisão do presente instrumento.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 9ª - DO SEGURO</p>
        <p>Os valores a título de seguro contra furto, roubo e acidentes contratados para o veículo serão suportados pelo <strong>LOCADOR</strong>. Em caso de acionamento do seguro do veículo, por incidente ocorrido durante a vigência do presente instrumento, será de responsabilidade do <strong>LOCATÁRIO</strong> o pagamento da franquia, cujo custo é 8% do valor do veículo na Tabela FIPE.</p>
        <p class="paragraph"><strong>§1:</strong> O contrato da seguradora, assim como a integralidade de sua cobertura, se encontra disponível na sede da locadora, para consulta.</p>
        <p class="paragraph"><strong>§2:</strong> Os impostos e encargos incidentes sobre o veículo, como IPVA, seguro DPVAT e licenciamento anual são de responsabilidade da <strong>LOCADORA</strong>, não repassados ao <strong>LOCATÁRIO</strong>.</p>
        <p class="paragraph"><strong>§3:</strong> Em caso do bem, objeto deste contrato, sofrer sinistro ou qualquer prejuízo material, incorrerá em rescisão contratual.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 10ª - DA RESCISÃO</p>
        <p>Se qualquer das partes não convier à continuidade da locação, notificará à outra parte sua intenção de rescindir o contrato com 07 (sete) dias de antecedência em que o contrato continuará em vigência.</p>
        <p class="paragraph"><strong>§1:</strong> O <strong>LOCATÁRIO</strong> pagará uma multa no valor correspondente a 3 diárias, além do valor correspondente aos dias em que o veículo permanecer após a data em que deveria devolvê-lo.</p>
        <p class="paragraph"><strong>§2:</strong> A rescisão antecipada não isentará o <strong>LOCATÁRIO</strong> da responsabilidade pelo pagamento dos débitos decorrentes das obrigações contratuais até a data da efetiva devolução à <strong>LOCADORA</strong> com prazo descrito na Cláusula 5ª, nem das indenizações eventualmente devidas, mesmo que apurados após a referida rescisão.</p>
        <p class="paragraph"><strong>§3:</strong> O descumprimento de qualquer Cláusula contratual implicará resolução do contrato, independentemente de comunicação, sem prejuízo de multas e ou reparação de danos sofridos.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 11ª</p>
        <p>Em caso de inadimplemento de quaisquer das Cláusulas do presente instrumento, incidirá multa de 20% (vinte por cento) sobre o valor devido, além de juros de 10% (dez por cento) ao mês e correção monetária pelo índice IGPM/FGV, sem prejuízo da multa estabelecida em cada uma delas.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 12ª</p>
        <p>As partes elegem o Foro da Comarca de Santa Maria - RS para qualquer demanda a respeito do contrato.</p>
        <p>As partes assinam este instrumento após lido e estando de acordo, com as testemunhas abaixo.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 13ª - DO TRATAMENTO DE DADOS PESSOAIS E PROTEÇÃO DE DADOS (LGPD)</p>
        <p>As partes reconhecem que o presente contrato envolve o tratamento de dados pessoais do <strong>LOCATÁRIO</strong>, nos termos da <strong>Lei Geral de Proteção de Dados Pessoais (Lei n 13.709/2018 - LGPD)</strong>, comprometendo-se a cumprir integralmente as normas aplicáveis à proteção e privacidade desses dados.</p>
        <p class="paragraph"><strong>§1:</strong> O <strong>LOCADOR</strong> poderá coletar, armazenar e processar os seguintes dados do <strong>LOCATÁRIO</strong>, necessários para a execução deste contrato: <strong>nome completo, CPF, RG, endereço, telefone, e-mail, e informações do veículo locado</strong>.</p>
        <p class="paragraph"><strong>§2:</strong> Os dados do <strong>LOCATÁRIO</strong> serão utilizados <strong>exclusivamente para fins de execução e gestão do contrato de locação</strong>, comunicação entre as partes, cobrança de valores devidos, cumprimento de obrigações legais e regulatórias, e eventual comunicação às autoridades competentes em caso de infrações de trânsito, ilícitos ou outras situações previstas em lei.</p>
        <p class="paragraph"><strong>§3:</strong> O <strong>LOCATÁRIO</strong> <strong>autoriza expressamente</strong> a <strong>LOCADORA</strong> a compartilhar seus dados com terceiros estritamente necessários para o cumprimento das obrigações contratuais, incluindo, mas não se limitando a:</p>
        <p class="paragraph">I - Autoridades de trânsito para a indicação do condutor em casos de infrações;</p>
        <p class="paragraph">II - Seguradoras e empresas de rastreamento veicular, quando aplicável;</p>
        <p class="paragraph">III - Instituições financeiras para processamento de pagamentos e cobranças;</p>
        <p class="paragraph">IV - Empresas e sistemas de proteção ao crédito, em caso de inadimplência.</p>
        <p class="paragraph"><strong>§4:</strong> O <strong>LOCADOR</strong> <strong>adotará medidas técnicas e organizacionais adequadas</strong> para garantir a segurança dos dados pessoais do <strong>LOCATÁRIO</strong>, protegendo-os contra acessos não autorizados, perda, destruição, alteração ou qualquer outro tratamento indevido.</p>
        <p class="paragraph"><strong>§5:</strong> O <strong>LOCATÁRIO</strong> <strong>tem o direito de acessar, corrigir, atualizar ou solicitar a exclusão de seus dados pessoais</strong>, salvo quando a manutenção for necessária para cumprimento de obrigações legais ou regulatórias. Tais solicitações deverão ser feitas por escrito à <strong>LOCADORA</strong>.</p>
        <p class="paragraph"><strong>§6:</strong> O <strong>LOCATÁRIO</strong> declara-se ciente de que, caso solicitado, seus dados poderão ser mantidos pela <strong>LOCADORA</strong> pelo <strong>prazo legal necessário para cumprimento de obrigações fiscais, contábeis e regulatórias</strong>, mesmo após o término do contrato.</p>
        <p class="paragraph"><strong>§7:</strong> Caso ocorra qualquer incidente de segurança que comprometa os dados do <strong>LOCATÁRIO</strong>, a <strong>LOCADORA</strong> se compromete a adotar as providências necessárias para mitigar os danos e comunicar às partes envolvidas, conforme exigido pela legislação vigente.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 14ª - DA REMOÇÃO DA TAG DA CHAVE</p>
        <p>O <strong>LOCATÁRIO</strong> compromete-se a não remover a TAG DE IDENTIFICAÇÃO DA CHAVE do veículo locado. A remoção desta tag resultará na aplicação de uma multa de R$20,00 (vinte reais), a ser cobrada no momento da devolução do veículo ou descontada da caução.</p>
        <p class="paragraph"><strong>§1:</strong> <strong>A TAG DE IDENTIFICAÇÃO</strong> tem a finalidade de organização e controle da frota, garantindo que cada chave esteja devidamente identificada com seu respectivo veículo.</p>
        <p class="paragraph"><strong>§2:</strong> A remoção da tag pode gerar dificuldades na administração da locadora, causando atrasos na conferência e entrega dos veículos, além de dificultar a rastreabilidade da chave em caso de perda ou extravio.</p>
        <p class="paragraph"><strong>§3:</strong> <strong>Caso a chave seja devolvida sem a tag, a LOCADORA considerará a remoção como descumprimento desta Cláusula, aplicando a respectiva multa.</strong></p>
    </div>
    <div class="location-date">
        <p>Santa Maria, {{ $data_hoje_extenso }}.</p>
    </div>
    <div class="signatures">
        <div class="signature-row">
            <div class="signature-block">
                <p><strong>PELA LOCADORA</strong></p>
                <div class="signature-line">
                    <p><strong>IZI CAR LOCAÇÕES DE VEÍCULOS</strong></p>
                    <p>CNPJ - 54.379.584/0001-87</p>
                </div>
            </div>
        </div>
        <div class="signature-row">
            <div class="signature-block">
                <p><strong>LOCATÁRIO</strong></p>
                <div class="signature-line">
                    <p><strong>{{ $motorista_nome }}</strong></p>
                    @if(!empty($motorista_cnh))<p>CNH - {{ $motorista_cnh }}</p>@endif
                    <p>CPF - {{ $motorista_documento }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
