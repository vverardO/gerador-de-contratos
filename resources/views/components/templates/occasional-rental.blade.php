<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Locacao de Veiculo</title>
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
        }
        .signature-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 60px;
        }
        .signature-block {
            width: 45%;
            text-align: center;
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
        @media print {
            body {
                padding: 20px 40px;
            }
        }
    </style>
</head>
<body>
    <h1 class="header">CONTRATO DE LOCACAO DE VEICULO POR PRAZO DETERMINADO - EVENTUAL</h1>

    <div class="section">
        <p><span class="bold underline">LOCADOR</span>: IZI CAR LOCACOES DE VEICULOS CNPJ: 54.379.584/0001-87, AV Liberdade 207B, bairro Passo da Areia, CEP 97010-270.</p>
    </div>

    <div class="section">
        <p><span class="bold underline">LOCATARIO</span>: {{ $motorista_nome }}, brasileiro, solteiro, CPF {{ $motorista_documento }}, endereco {{ $motorista_rua }}, N {{ $motorista_numero }}, Bairro {{ $motorista_bairro }}, CEP {{ $motorista_cep }}.</p>
    </div>

    <div class="section">
        <p><span class="bold underline">VEICULO</span>: O presente contrato tem como objeto unico e exclusivo a Locacao do automovel com as seguintes informacoes: {{ $veiculo }}, ano de fabricacao e modelo {{ $fabricacao_modelo }}, placa {{ $placa }}, chassi {{ $chassi }}, RENAVAM {{ $renavam }}.</p>
    </div>

    <div class="section">
        <p><span class="bold underline">PROPRIETARIO DO VEICULO</span>: {{ $proprietario_nome }}, CPF/CNPJ {{ $proprietario_documento }}.</p>
    </div>

    <div class="section">
        <p><span class="bold underline">PRAZO DO CONTRATO</span>: 30 (trinta dias), renovavel automaticamente a cada 30 (trinta) dias, sucessivamente, enquanto convier as partes.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 1a - DO OBJETO DO CONTRATO</p>
        <p>O presente contrato tem como objeto a locacao do veiculo acima caracterizado, mediante a remuneracao DIARIA de R$ {{ $valor }} ({{ $valor_extenso }}), podendo ser utilizado pelo locatario durante as 24 horas do dia.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 2a - DO PRAZO</p>
        <p>O presente contrato tem como objeto a locacao do veiculo acima caracterizado, mediante a remuneracao DIARIA, devendo ser paga ate as 23:59hrs, podendo ser utilizado pelo locatario durante as 24 horas do dia, por 30 (trinta dias), renovavel automaticamente a cada 30 (trinta) dias, sucessivamente, enquanto convier as partes.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 3a - DO USO</p>
        <p>O objeto deste contrato, sera utilizado exclusivamente pelo LOCATARIO, especialmente para utilizacao em plataformas (aplicativos) de passageiros, tais como: 99, uber, indrive e semelhantes.</p>
        <p class="paragraph"><strong>S1:</strong> Fica o LOCATARIO responsavel por seguir as diretrizes e atender as exigencias de credenciamento das referidas plataformas.</p>
        <p class="paragraph"><strong>S 2:</strong> Nao e permitida a utilizacao do veiculo por terceiro, sob pena de rescisao contratual e multa no valor correspondente a 10 diarias de locacao.</p>
        <p class="paragraph"><strong>S 3:</strong> E vedada a utilizacao do veiculo para transportes produtos ilicitos ou pratica de ilicitos, sob pena de rescisao contratual, com o pagamento de multa no valor correspondente a 10 diarias de locacao, sem prejuizo de ressarcimento de outras despesas que isso ocasionar para a LOCADORA ou proprietario do veiculo.</p>
        <p class="paragraph"><strong>S 4:</strong> O <strong>LOCATARIO</strong> nao podera sair com o veiculo fora do perimetro urbano sem previa autorizacao formal da <strong>LOCADORA</strong>. Se o fizer, estara violando o contrato.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 4a - DO VALOR</p>
        <p>A titulo de contraprestacao, o <strong>LOCATARIO</strong> pagara ao <strong>LOCADOR</strong> o valor da diaria de R$ {{ $valor }} ({{ $valor_extenso }}) durante a vigencia do contrato.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 5a - DO PAGAMENTO E DA QUEBRA DO CONTRATO POR INADIMPLEMENTO</p>
        <p>O pagamento do aluguel sera feito diariamente. Na sede da locadora, podera ser pago em dinheiro, por pix chave: CNPJ <strong>54.379.584/0001-87</strong>, sob pena de resolucao do contrato, valendo o comprovante como quitacao da obrigacao. O nao pagamento da diaria por tres dias consecutivos ocasionara o bloqueio imediato do veiculo, bem como seu recolhimento ao <strong>LOCADOR</strong> e o <strong>LOCATARIO</strong> respondera por apropriacao indebita do bem, de acordo com o disposto no artigo 168 do Codigo Penal, quebra do contrato, presente na Clausula 10a S 3.</p>
        <p class="paragraph"><strong>S 1:</strong> <strong>O valor pago sera referente aos dias de locacao e o deposito/ PIX do valor devido servira como quitacao dos debitos anteriores referentes as diarias.</strong></p>
        <p class="paragraph"><strong>S 2:</strong> Em caso de inadimplemento, indicara a quebra de contrato, devendo ao LOCATARIO ressarcir todas as obrigacoes para com a LOCADORA, multas, av. diarias, sem prejuizo do disposto na Clausula 11a, sob pena da perda da caucao e Fundo do Locatario.</p>
        <p class="paragraph"><strong>S 3:</strong> Fica acordado entre as partes que na hipotese de nao pagamento da locacao do veiculo por parte do LOCATARIO, o atraso de pagamento igual ou superior a 03 (tres) dias acarretara na imediata retomada (posse do automovel por parte da LOCADORA), perda da caucao e imediata cobranca da multa de rescisao estipulada neste contrato.</p>
        <p class="paragraph"><strong>S 4:</strong> <strong>Na hipotese de atraso do pagamento da diaria sera cobrada juros de 2% ao dia sobre o valor das diarias em atraso.</strong></p>
        <p class="paragraph"><strong>S 5:</strong> Fica o LOCATARIO ciente de que estando com 03(tres) ou mais diarias em atraso o veiculo podera ser bloqueado e retomado a qualquer tempo por parte da LOCADORA. Nao onerando a LOCADORA de qualquer transtorno ou custas devido ao bloqueio do veiculo.</p>
        <p class="paragraph"><strong>S 6:</strong> Em caso de inadimplencia do LOCATARIO por 01 (um) dia ou mais, o LOCADOR podera realizar o bloqueio imediato do veiculo, por meio de sistema de rastreamento, sem necessidade de aviso previo, ate a regularizacao integral dos debitos.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 6a - DA GARANTIA E DO FUNDO DO LOCATARIO</p>
        <p>Como garantia do presente contrato, o LOCATARIO pagou a quantia de R$500,00 (QUINHENTOS REAIS) o qual equivale a parte do valor da franquia de seguro do veiculo, objeto do presente instrumento.</p>
        <p class="paragraph"><strong>S 1:</strong> Se o LOCATARIO nao restituir o veiculo na data estipulada contratualmente, sem a realizacao de aditivo contratual, implicara a perda da caucao, alem de responder pelos danos que o automovel vier a sofrer mesmo se provenientes de caso fortuito ou forca maior, sem prejuizo do pagamento das diarias ate a data da entrega do veiculo a LOCADORA.</p>
        <p class="paragraph"><strong>S 2:</strong> A caucao sera devolvida em ate 30 dias uteis, apos final da locacao, ou de haver valores que sejam devidos pelo locatario, por aluguel, multas, avarias os possiveis debitos serao descontados do caucao.</p>
        <p class="paragraph"><strong>S 3:</strong> Caso o locatario resolva devolver o veiculo objeto deste contrato antes do prazo inicial de 30 dias, o valor acumulado de caucao referente ao tempo em que ficou com o carro nao sera devolvido a titulo de quebra de contrato.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 7a - DAS CONDICOES DO VEICULO</p>
        <p>O LOCATARIO reconhece que vistoriou o veiculo e que devera devolve-lo a LOCADORA nas mesmas condicoes em que o recebeu, ou seja, em perfeito estado de uso, com detalhes incluidos na FICHA DE VISTORIA e ou fotografias que fara parte do presente instrumento, sem quaisquer avarias, respondendo pelos danos ou prejuizos causados, podendo a LOCADORA submete-lo a exames por mecanico de sua confianca. O LOCATARIO assume responsabilidade por danos ou prejuizos que vier a causar.</p>
        <p class="paragraph"><strong>S 1:</strong> Quando as partes resolverem rescindir o contrato o LOCATARIO fica responsavel por devolver o veiculo com a gasolina no mesmo nivel em que recebeu, o qual sera tirado uma foto do marcador no dia em que o veiculo for entregue ao locatario. Caso o LOCATARIO nao devolva no mesmo nivel, a LOCADORA efetuara o preenchimento do combustivel e o valor sera descontado em dobro do caucao.</p>
        <p class="paragraph"><strong>S 2:</strong> E terminantemente proibido fumar no veiculo e a responsabilidade de passageiros de o fazerem cabe exclusivamente ao LOCATARIO, que podera arcar com a taxa de higienizacao de fumaca no valor de R$300,00 (trezentos reais).</p>
        <p class="paragraph"><strong>S 3:</strong> A Locadora realizara a entrega do veiculo ao LOCATARIO devidamente limpo e higienizado. A falta da limpeza completa no momento da entrega ensejara a cobranca da taxa de limpeza no valor de R$120,00 (cento e vinte reais).</p>
        <p class="paragraph"><strong>S 4:</strong> Os valores constantes nos paragrafos 1 e 2 da presente clausula serao descontados da caucao, no momento da devolucao do veiculo.</p>
        <p class="paragraph"><strong>S 5:</strong> O LOCATARIO podera solicitar a troca do veiculo durante a vigencia do contrato, mediante o pagamento de uma taxa unica no valor de R$ 100,00 (cem reais). A troca sera realizada de acordo com a disponibilidade de veiculos na frota da LOCADORA e sera formalizada mediante novo contrato.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 8a - DAS RESPONSABILIDADES</p>
        <p>O LOCATARIO assume exclusivamente a responsabilidade civil, criminal e administrativa por todos os fatos ou danos que vierem a ocorrer com o veiculo locado durante a vigencia da locacao. Responsabiliza-se pelo valor pecuniario e pontuacao decorrentes de infracoes de transito por autuacoes no periodo da locacao, inclusive taxas cartorarias e de correio.</p>
        <p class="paragraph"><strong>S 1:</strong> Com a expedicao de auto de infracao o LOCATARIO compromete-se em assinar a notificacao de autuacao reconhecendo-se como condutor/infrator nas infracoes cometidas na vigencia do contrato, devendo para tal disponibilizar a documentacao exigida e no prazo indicado pelo Departamento de Transito, ainda que a notificacao seja remetida apos o termino do lapso temporal contratado.</p>
        <p class="paragraph"><strong>S 2:</strong> O LOCATARIO devera arcar com o reparo de todos os danos porventura constatados no veiculo no prazo de ate 10 (dez) dias da data de sua devolucao, ficando a cargo da LOCADORA escolher as pecas e os profissionais que realizarao o conserto, independentemente do valor, sem prejuizo do pagamento a LOCADORA, a titulo de ressarcimento por prejuizo causado ao Locador.</p>
        <p class="paragraph"><strong>S 3:</strong> E estritamente proibido qualquer modificacao, conserto ou troca de pecas ou itens do veiculo sem aviso previo e autorizacao formalizada da LOCADORA, e se constatada alguma irregularidade neste sentido o LOCATARIO se responsabiliza pelo custo de reparacao dos danos ocasionados, assim como pelo refazimento de conserto e troca de pecas ou itens providenciado pela LOCADORA.</p>
        <p class="paragraph"><strong>S 4:</strong> Sera apresentado de forma online (atraves do endereco posdetran.rs.gov.br) as multas que venham a incidir sobre o veiculo locado no prazo da locacao. O LOCATARIO tera o prazo de 24h para confirmacao atraves do e-mail ou telefone cadastrado no Detran sua responsabilidade. Caso o LOCATARIO nao consiga acessar "gov.br" ou e-mail cadastrado ao DETRAN, a solicitacao de real condutor sera realizada em documento impresso da maneira tradicional no mesmo prazo estipulado de forma online. As multas deverao ser pagas imediatamente apos sua identificacao.</p>
        <p class="paragraph"><strong>S 5:</strong> O LOCATARIO obriga-se a encaminhar ao LOCADOR, toda segunda-feira, a informacao da quilometragem atual do veiculo, por meio dos canais indicados, com a finalidade de controle de manutencao preventiva e garantia do bom funcionamento do bem locado. O nao envio da quilometragem, apos solicitacao, autoriza o LOCADOR a realizar o bloqueio preventivo do veiculo, por meio de sistema de rastreamento, sem aviso previo, ate a regularizacao da obrigacao, nao configurando abuso de direito.</p>
        <p class="paragraph"><strong>S 6:</strong> A LOCADORA se compromete de resolver em tempo habil, quando necessarias as manutencoes e consertos inerentes ao desgaste natural ou troca de fluidos que venham a incidir sobre o veiculo durante a vigencia do contrato. Destaca-se que troca de lampada, pneu furado, ou avarias ocorridas pelo mau uso do veiculo sao de inteira responsabilidade do LOCATARIO.</p>
        <p class="paragraph"><strong>S 7:</strong> Quando o veiculo passar por manutencao que ocasione impossibilidade de utilizacao, desde que esta manutencao nao tenha sido provocada pelo LOCATARIO e facultado ao mesmo o desconto DA FRACAO DO DIA em que o veiculo nao foi utilizado ou utilizacao de outro veiculo disponivel, de qualidade similar, ofertado pela LOCADORA, se houver.</p>
        <p class="paragraph"><strong>S 8:</strong> A devolucao da caucao somente ocorrera apos o decurso do prazo de 30 dias uteis a fim de resguardar o direito de retencao quanto as multas ou prejuizos que se apresentem supervenientes ao prazo de validade do contrato.</p>
        <p class="paragraph"><strong>S 9:</strong> O LOCATARIO compromete-se em aceitar a indicacao de "principal condutor" do veiculo objeto deste contrato em no maximo 24 horas a contar assinatura do mesmo, sob pena de rescisao contratual e perda de caucao caso nao o faca.</p>
        <p class="paragraph"><strong>S 10:</strong> Caso o LOCATARIO nao tenha acesso ao seu aplicativo do "GOV.BR" para fazer o aceite como "Principal Condutor" do veiculo, sera dado ao mesmo o prazo de 4 dias uteis para que regularize o seu acesso ao aplicativo e possa fazer o aceite. Caso o mesmo nao o faca estara violando o presente contrato e estara sujeito a bloqueio do veiculo e rescisao do presente instrumento.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 9a - DO SEGURO</p>
        <p>Os valores a titulo de seguro contra furto, roubo e acidentes contratados para o veiculo serao suportados pelo LOCADOR. Em caso de acionamento do seguro do veiculo, por incidente ocorrido durante a vigencia do presente instrumento, sera de responsabilidade do LOCATARIO o pagamento da franquia, cujo custo e 8% do valor do veiculo na Tabela FIPE.</p>
        <p class="paragraph"><strong>S 1:</strong> O contrato da seguradora, assim como a integralidade de sua cobertura, se encontra disponivel na sede da locadora, para consulta.</p>
        <p class="paragraph"><strong>S 2:</strong> Os impostos e encargos incidentes sobre o veiculo, como IPVA, seguro DPVAT e licenciamento anual sao de responsabilidade da LOCADORA, nao repassados ao LOCATARIO.</p>
        <p class="paragraph"><strong>S 3:</strong> Em caso do bem, objeto deste contrato, sofrer sinistro ou qualquer prejuizo material, incorrera em rescisao contratual.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 10a - DA RESCISAO</p>
        <p>Se qualquer das partes nao convier a continuidade da locacao, notificara parte sua intencao de rescindir o contrato com 07 (sete) dias de antecedencia em que o contrato continuara em vigencia.</p>
        <p class="paragraph"><strong>S1:</strong> O LOCATARIO pagara uma multa no valor correspondente a 3 diarias, alem do valor correspondente aos dias em que o veiculo permanecer apos a data em que deveria devolve-lo.</p>
        <p class="paragraph"><strong>S 2:</strong> A rescisao antecipada nao isentara o LOCATARIO da responsabilidade pelo pagamento dos debitos decorrentes das obrigacoes contratuais ate a data da efetiva devolucao a LOCADORA com prazo descrito na CLAUSULA 5a, nem das indenizacoes eventualmente devidas, mesmo que apurados apos a referida rescisao.</p>
        <p class="paragraph"><strong>S 3:</strong> O descumprimento de qualquer clausula contratual implicara resolucao do contrato, independentemente de comunicacao, sem prejuizo de multas e ou reparacao de danos sofridos.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 11a</p>
        <p>Em caso de inadimplemento de quaisquer das clausulas do presente instrumento, incidira multa de 20% (vinte por cento) sobre o valor devido, alem de juros de 10% (dez por cento) ao mes e correcao monetaria pelo indice IGPM/FGV, sem prejuizo da multa estabelecida em cada uma delas.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 12a</p>
        <p>As partes elegem o Foro da Comarca de Santa Maria - RS para qualquer demanda a respeito do contrato.</p>
        <p>As partes assinam este instrumento apos lido e estando de acordo, com as testemunhas abaixo.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 13a - DO TRATAMENTO DE DADOS PESSOAIS E PROTECAO DE DADOS (LGPD)</p>
        <p>As partes reconhecem que o presente contrato envolve o tratamento de dados pessoais do LOCATARIO, nos termos da <strong>Lei Geral de Protecao de Dados Pessoais (Lei n 13.709/2018 - LGPD)</strong>, comprometendo-se a cumprir integralmente as normas aplicaveis a protecao e privacidade desses dados.</p>
        <p class="paragraph"><strong>S 1:</strong> O LOCADOR podera coletar, armazenar e processar os seguintes dados do LOCATARIO, necessarios para a execucao deste contrato: <strong>nome completo, CPF, RG, endereco, telefone, e-mail, e informacoes do veiculo locado</strong>.</p>
        <p class="paragraph"><strong>S 2:</strong> Os dados do LOCATARIO serao utilizados <strong>exclusivamente para fins de execucao e gestao do contrato de locacao</strong>, comunicacao entre as partes, cobranca de valores devidos, cumprimento de obrigacoes legais e regulatorias, e eventual comunicacao as autoridades competentes em caso de infracoes de transito, ilicitos ou outras situacoes previstas em lei.</p>
        <p class="paragraph"><strong>S 3:</strong> O LOCATARIO <strong>autoriza expressamente</strong> a LOCADORA a compartilhar seus dados com terceiros estritamente necessarios para o cumprimento das obrigacoes contratuais, incluindo, mas nao se limitando a:</p>
        <p class="paragraph">I - Autoridades de transito para a indicacao do condutor em casos de infracoes;</p>
        <p class="paragraph">II - Seguradoras e empresas de rastreamento veicular, quando aplicavel;</p>
        <p class="paragraph">III - Instituicoes financeiras para processamento de pagamentos e cobrancas;</p>
        <p class="paragraph">IV - Empresas e sistemas de protecao ao credito, em caso de inadimplencia.</p>
        <p class="paragraph"><strong>S 4:</strong> O LOCADOR <strong>adotara medidas tecnicas e organizacionais adequadas</strong> para garantir a seguranca dos dados pessoais do LOCATARIO, protegendo-os contra acessos nao autorizados, perda, destruicao, alteracao ou qualquer outro tratamento indevido.</p>
        <p class="paragraph"><strong>S 5:</strong> O LOCATARIO <strong>tem o direito de acessar, corrigir, atualizar ou solicitar a exclusao de seus dados pessoais</strong>, salvo quando a manutencao for necessaria para cumprimento de obrigacoes legais ou regulatorias. Tais solicitacoes deverao ser feitas por escrito a LOCADORA.</p>
        <p class="paragraph"><strong>S 6:</strong> O LOCATARIO declara-se ciente de que, caso solicitado, seus dados poderao ser mantidos pela LOCADORA pelo <strong>prazo legal necessario para cumprimento de obrigacoes fiscais, contabeis e regulatorias</strong>, mesmo apos o termino do contrato.</p>
        <p class="paragraph"><strong>S 7:</strong> Caso ocorra qualquer incidente de seguranca que comprometa os dados do LOCATARIO, a LOCADORA se compromete a adotar as providencias necessarias para mitigar os danos e comunicar as partes envolvidas, conforme exigido pela legislacao vigente.</p>
    </div>

    <div class="clause">
        <p class="clause-title">CLAUSULA 14a - DA REMOCAO DA TAG DA CHAVE</p>
        <p>O LOCATARIO compromete-se a nao remover a TAG DE IDENTIFICACAO DA CHAVE do veiculo locado. A remocao desta tag resultara na aplicacao de uma multa de R$20,00 (vinte reais), a ser cobrada no momento da devolucao do veiculo ou descontada da caucao.</p>
        <p class="paragraph"><strong>S 1:</strong> <strong>A TAG DE IDENTIFICACAO</strong> tem a finalidade de organizacao e controle da frota, garantindo que cada chave esteja devidamente identificada com seu respectivo veiculo.</p>
        <p class="paragraph"><strong>S 2:</strong> A remocao da tag pode gerar dificuldades na administracao da locadora, causando atrasos na conferencia e entrega dos veiculos, alem de dificultar a rastreabilidade da chave em caso de perda ou extravio.</p>
        <p class="paragraph"><strong>S 3:</strong> <strong>Caso a chave seja devolvida sem a tag, a LOCADORA considerara a remocao como descumprimento desta clausula, aplicando a respectiva multa.</strong></p>
    </div>

    <div class="location-date">
        <p>Santa Maria, {{ $data_hoje }}.</p>
    </div>

    <div class="signatures">
        <div class="signature-row">
            <div class="signature-block">
                <p><strong>PELA LOCADORA</strong></p>
                <div class="signature-line">
                    <p><strong>GABRIEL CEZIMBRA</strong></p>
                    <p>038.109.650-57</p>
                </div>
            </div>
            <div class="signature-block">
                <p><strong>LOCATARIO</strong></p>
                <div class="signature-line">
                    <p><strong>{{ $motorista_nome }}</strong></p>
                    <p>{{ $motorista_documento }}</p>
                </div>
            </div>
        </div>

        <div class="witnesses">
            <p><strong>TESTEMUNHAS</strong></p>
            <div class="signature-row">
                <div class="signature-block">
                    <div class="signature-line">
                        <p>NOME</p>
                        <p>CPF</p>
                    </div>
                </div>
                <div class="signature-block">
                    <div class="signature-line">
                        <p>NOME</p>
                        <p>CPF</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
