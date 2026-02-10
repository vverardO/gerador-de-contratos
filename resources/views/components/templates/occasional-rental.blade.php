<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Locação de Veículo por Prazo Determinado</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Georgia, 'Times New Roman', serif;
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
    <div class="documentHeader">
        <img src="/images/watter_mark.jpg" alt="IZI CAR" class="headerLogo">
        <div class="headerTitles">
            <h1 class="header">CONTRATO DE LOCAÇÃO DE VEÍCULO POR PRAZO DETERMINADO</h1>
            <h3 class="header">Contrato Nº: {{ $contract_id }}</h3>
        </div>
        <img src="/images/watter_mark.jpg" alt="IZI CAR" class="headerLogo">
    </div>
    <div class="section">
        <p><span class="bold underline">LOCADOR</span>: IZI CAR LOCAÇÕES DE VEÍCULOS, pessoa jurídica de direito privado, inscrita no CNPJ sob nº 54.379.584/0001-87, com sede na Av. Liberdade, nº 207B, Bairro Passo da Areia, CEP 97010-270.</p>
    </div>
    <div class="section">
        <p><span class="bold underline">LOCATÁRIO</span>: {{ $motorista_nome }}, brasileiro, solteiro, @if(!empty($motorista_cnh))CNH nº {{ $motorista_cnh }}, @endif CPF {{ $motorista_documento }}, residente e domiciliado à {{ $motorista_rua }}, nº {{ $motorista_numero }}, Bairro {{ $motorista_bairro }}, CEP {{ $motorista_cep }}.</p>
    </div>
    <div class="section">
        <p><span class="bold underline">VEÍCULO</span>: O presente contrato tem como objeto único e exclusivo a locação do automóvel com as seguintes informações: {{ $veiculo }}, ano de fabricação/modelo {{ $fabricacao_modelo }}, placa {{ $placa }}, chassi {{ $chassi }}, RENAVAM {{ $renavam }}.</p>
    </div>
    <div class="section">
        <p><span class="bold underline">PROPRIETÁRIO DO VEÍCULO</span>: {{ $proprietario_nome }}, CPF/CNPJ {{ $proprietario_documento }}.</p>
    </div>
    <div class="section">
        <p><span class="bold underline">PRAZO DO CONTRATO</span>: {{ $quantidade_dias }} dias.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 1ª – DO OBJETO DO CONTRATO</p>
        <p>O presente contrato tem como objeto a locação do veículo acima caracterizado, pelo período determinado, mediante remuneração total de R$ {{ $valor_total }} ({{ $valor_total_extenso }}), referente à locação pelo prazo de {{ $quantidade_dias }} dias, compreendidos entre {{ $data_inicio }} e {{ $data_fim }}.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 2ª – DO PRAZO</p>
        <p>O presente contrato vigorará pelo prazo determinado de {{ $quantidade_dias }} dias, com início em {{ $data_inicio }} e término em {{ $data_fim }}, data em que o veículo deverá ser devolvido ao LOCADOR, nas condições previstas neste contrato.</p>
        <p class="paragraph">Parágrafo único. Findo o prazo estipulado, a permanência do veículo em posse do LOCATÁRIO somente será permitida mediante anuência expressa do LOCADOR, podendo ser cobrado valor adicional conforme tabela vigente.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 3ª – DO USO DO VEÍCULO</p>
        <p>O veículo objeto deste contrato será utilizado exclusivamente pelo LOCATÁRIO, para uso particular, sendo vedada sua utilização para fins comerciais, transporte remunerado de passageiros, aplicativos, sublocação ou qualquer finalidade diversa da informada no momento da contratação.</p>
        <p class="paragraph"><strong>§1º</strong> É vedada a utilização do veículo por terceiros, ainda que habilitados, sob pena de rescisão imediata do contrato, aplicação de multa equivalente a 4 (quatro) vezes o valor da diária contratada, perda integral da caução e demais cominações legais.</p>
        <p class="paragraph"><strong>§2º</strong> É expressamente proibida a utilização do veículo para o transporte de produtos ilícitos ou para a prática de quaisquer atos ilegais, hipótese em que o contrato será rescindido de pleno direito, com aplicação de multa equivalente a 4 (quatro) vezes o valor da diária, além do ressarcimento integral de todos os prejuízos causados à LOCADORA ou ao proprietário do veículo.</p>
        <p class="paragraph"><strong>§3º</strong> O LOCATÁRIO declara que o destino e o percurso da viagem foram previamente informados e acordados com a LOCADORA, comprometendo-se a não ultrapassar o destino autorizado sem prévia e expressa autorização formal.</p>
        <p class="paragraph"><strong>§4º</strong> O descumprimento do destino previamente acordado, a saída do veículo para localidade diversa sem autorização ou qualquer infração às disposições desta cláusula caracterizam infração grave e quebra contratual, autorizando a LOCADORA a proceder com o bloqueio preventivo do veículo por meio do sistema de rastreamento, independentemente de aviso prévio, bem como à rescisão imediata do contrato, perda integral da caução e aplicação de multa equivalente a 4 (quatro) vezes o valor da diária contratada.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 4ª – DO VALOR</p>
        <p>A título de contraprestação pela locação do veículo, o LOCATÁRIO pagará ao LOCADOR o valor total de R$ {{ $valor_total }} ({{ $valor_total_extenso }}), correspondente ao período de locação previamente contratado, conforme disposto nas Cláusulas 1ª e 2ª deste contrato.</p>
        <p class="paragraph">Parágrafo único. O valor ora ajustado refere-se à locação pelo período determinado, não havendo cobrança de diária durante a vigência do prazo contratado, salvo nas hipóteses de prorrogação, atraso na devolução ou infração contratual.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 5ª – DO PAGAMENTO, DA PRORROGAÇÃO E DA INADIMPLÊNCIA</p>
        <p>O pagamento do valor total da locação deverá ser realizado integralmente no ato da retirada do veículo, por meio de PIX, transferência bancária ou outro meio previamente autorizado pela LOCADORA, valendo o comprovante como quitação da obrigação.</p>
        <p class="paragraph"><strong>§1º</strong> Na hipótese de prorrogação do prazo de locação, esta somente será válida mediante anuência expressa da LOCADORA, devendo o LOCATÁRIO efetuar o pagamento antecipado do valor correspondente aos dias adicionais.</p>
        <p class="paragraph"><strong>§2º</strong> O uso do veículo além do prazo contratado, sem autorização e sem o pagamento prévio da prorrogação, caracteriza inadimplência grave e quebra contratual, autorizando a LOCADORA a proceder com o bloqueio imediato do veículo por meio do sistema de rastreamento, bem como à retomada da posse do bem, independentemente de aviso prévio.</p>
        <p class="paragraph"><strong>§3º</strong> Na hipótese de retomada do veículo em razão de inadimplência, atraso na devolução ou descumprimento contratual, o LOCATÁRIO arcará com taxa de remoção no valor de R$ 5,00 (cinco reais) por quilômetro, calculada com base na distância de ida e volta entre a sede da LOCADORA e o local onde o veículo for encontrado, sem prejuízo da perda da caução, multas contratuais e ressarcimento de eventuais danos.</p>
        <p class="paragraph"><strong>§4º</strong> A inadimplência implicará, ainda, na rescisão imediata do contrato, perda integral da caução, aplicação das penalidades previstas neste instrumento e cobrança de quaisquer valores pendentes, inclusive despesas operacionais, administrativas e de recuperação do veículo.</p>
        <p class="paragraph"><strong>§5º</strong> O LOCATÁRIO declara estar ciente e de pleno acordo que o bloqueio remoto e a retomada do veículo constituem medidas legítimas de proteção patrimonial da LOCADORA, não configurando abuso de direito, enquanto perdurar a situação de inadimplência ou infração contratual.</p>
        <p class="paragraph"><strong>§6º</strong> Persistindo a inadimplência e a retenção indevida do veículo, tal conduta poderá caracterizar apropriação indevida, nos termos do artigo 168 do Código Penal Brasileiro, sem prejuízo das sanções civis e contratuais previstas neste instrumento.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 6ª – DA GARANTIA E DO FUNDO DO LOCATÁRIO</p>
        <p>Como garantia do presente contrato, o LOCATÁRIO pagou a quantia de R$ {{ $caucao }} ({{ $caucao_extenso }}), equivalente a parte do valor da franquia do seguro do veículo objeto deste instrumento.</p>
        <p class="paragraph"><strong>§1º</strong> A não restituição do veículo na data estipulada contratualmente, sem aditivo, implicará a perda da caução, além da responsabilidade do LOCATÁRIO por eventuais danos sofridos pelo automóvel, inclusive por caso fortuito ou força maior, sem prejuízo do pagamento das diárias até a efetiva entrega.</p>
        <p class="paragraph"><strong>§2º</strong> A caução será devolvida em até 30 (trinta) dias úteis após o término da locação, descontados eventuais valores devidos a título de aluguel, multas ou avarias.</p>
        <p class="paragraph"><strong>§3º</strong> Caso o LOCATÁRIO devolva o veículo antes do prazo inicialmente contratado, o valor acumulado da caução não será devolvido, a título de quebra contratual.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 7ª – DAS CONDIÇÕES DO VEÍCULO</p>
        <p>O LOCATÁRIO reconhece que vistoriou o veículo e que deverá devolvê-lo à LOCADORA nas mesmas condições em que o recebeu, ou seja, em perfeito estado de uso, com detalhes incluídos na FICHA DE VISTORIA e/ou fotografias, que farão parte integrante do presente instrumento, sem quaisquer avarias, respondendo pelos danos ou prejuízos causados, podendo a LOCADORA submetê-lo a exames por mecânico de sua confiança. O LOCATÁRIO assume responsabilidade por danos ou prejuízos que vier a causar.</p>
        <p class="paragraph"><strong>§ 1º</strong> Quando as partes resolverem rescindir o contrato, o LOCATÁRIO fica responsável por devolver o veículo com a gasolina no mesmo nível em que recebeu, o qual será registrado por meio de fotografia do marcador no dia da entrega do veículo. Caso o LOCATÁRIO não devolva o veículo no mesmo nível de combustível, a LOCADORA efetuará o abastecimento necessário e o valor correspondente será descontado em dobro da caução.</p>
        <p class="paragraph"><strong>§ 2º</strong> É terminantemente proibido fumar no interior do veículo, sendo o LOCATÁRIO integralmente responsável por seus passageiros. O descumprimento desta obrigação ensejará a cobrança de taxa de higienização no valor de R$ 300,00 (trezentos reais).</p>
        <p class="paragraph"><strong>§ 3º</strong> A LOCADORA realizará a entrega do veículo ao LOCATÁRIO devidamente limpo e higienizado. A devolução do veículo sem a limpeza adequada ensejará a cobrança de taxa de limpeza no valor de R$ 120,00 (cento e vinte reais).</p>
        <p class="paragraph"><strong>§ 4º</strong> Os valores constantes nos §§ 1º e 2º da presente cláusula serão descontados da caução no momento da devolução do veículo.</p>
        <p class="paragraph"><strong>§ 5º</strong> O LOCATÁRIO poderá solicitar a troca do veículo durante a vigência do contrato, mediante o pagamento de taxa única no valor de R$ 100,00 (cem reais). A troca estará condicionada à disponibilidade da frota da LOCADORA e será formalizada mediante novo contrato.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 8ª – DAS RESPONSABILIDADES</p>
        <p>O LOCATÁRIO assume exclusivamente a responsabilidade civil, criminal e administrativa por todos os fatos ou danos que vierem a ocorrer com o veículo locado durante a vigência da locação, responsabilizando-se integralmente pelo pagamento de multas, pontuação e demais encargos decorrentes de infrações de trânsito cometidas no período da locação, inclusive taxas cartorárias e de correio.</p>
        <p class="paragraph"><strong>§ 1º</strong> Com a expedição de auto de infração, o LOCATÁRIO compromete-se a reconhecer-se como condutor/infrator das infrações cometidas durante a vigência do contrato, devendo fornecer a documentação necessária e cumprir os prazos estabelecidos pelo órgão de trânsito competente, ainda que a notificação seja expedida após o término do contrato.</p>
        <p class="paragraph"><strong>§ 2º</strong> O LOCATÁRIO deverá arcar com o reparo de todos os danos constatados no veículo no prazo de até 10 (dez) dias a contar da data de sua devolução, ficando a critério da LOCADORA a escolha das peças e dos profissionais responsáveis pelo reparo, independentemente do valor.</p>
        <p class="paragraph"><strong>§ 3º</strong> É expressamente proibida qualquer modificação, conserto ou substituição de peças ou itens do veículo sem autorização prévia e formal da LOCADORA. Constatada a irregularidade, o LOCATÁRIO será responsável pelos custos de reparação e pelo refazimento dos serviços.</p>
        <p class="paragraph"><strong>§ 4º</strong> As multas que incidirem sobre o veículo durante o período da locação serão apresentadas ao LOCATÁRIO por meio eletrônico. O LOCATÁRIO compromete-se a efetuar o pagamento imediato das multas após sua identificação.</p>
        <p class="paragraph"><strong>§ 5º</strong> O LOCATÁRIO obriga-se a encaminhar ao LOCADOR, toda segunda-feira, a informação da quilometragem atual do veículo, pelos canais indicados, para fins de controle de manutenção preventiva. O não envio autoriza o bloqueio preventivo do veículo, por meio de sistema de rastreamento, sem aviso prévio, até a regularização da obrigação, não configurando abuso de direito.</p>
        <p class="paragraph"><strong>§ 6º</strong> A LOCADORA compromete-se a realizar, em tempo hábil, as manutenções inerentes ao desgaste natural do veículo. Troca de lâmpadas, pneus furados ou avarias decorrentes de mau uso são de inteira responsabilidade do LOCATÁRIO.</p>
        <p class="paragraph"><strong>§ 7º</strong> Quando o veículo permanecer indisponível por manutenção não provocada pelo LOCATÁRIO, este poderá optar pelo desconto proporcional da fração do dia em que o veículo não foi utilizado ou pela utilização de outro veículo de categoria similar, se disponível.</p>
        <p class="paragraph"><strong>§ 8º</strong> A devolução da caução ocorrerá somente após o prazo de 30 (trinta) dias úteis, a fim de resguardar a LOCADORA quanto a multas ou prejuízos supervenientes.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 9ª – DO SEGURO</p>
        <p>Os valores a título de seguro contra furto, roubo e acidentes contratados para o veículo serão suportados pelo LOCADOR. Em caso de acionamento do seguro do veículo, por incidente ocorrido durante a vigência do presente instrumento, será de responsabilidade do LOCATÁRIO o pagamento da franquia, cujo custo é 8% do valor do veículo na Tabela FIPE.</p>
        <p class="paragraph"><strong>§ 1º:</strong> O contrato da seguradora, assim como a integralidade de sua cobertura, se encontra disponível na sede da locadora, para consulta.</p>
        <p class="paragraph"><strong>§ 2°:</strong> Os impostos e encargos incidentes sobre o veículo, como IPVA, seguro DPVAT e licenciamento anual são de responsabilidade da LOCADORA, não repassados ao LOCATÁRIO.</p>
        <p class="paragraph"><strong>§ 3°:</strong> Em caso do bem, objeto deste contrato, sofrer sinistro ou qualquer prejuízo material, incorrerá em rescisão contratual.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 10ª – DA RESCISÃO</p>
        <p>Se qualquer das partes não convier a continuidade da locação, notificará a outra parte sua intenção de rescindir o contrato com 07 (sete) dias de antecedência em que o contrato continuará em vigência.</p>
        <p class="paragraph"><strong>§1°:</strong> O LOCATÁRIO pagará uma multa no valor correspondente a 3 diárias, além do valor correspondente aos dias em que o veículo permanecer após a data em que deveria devolvê-lo.</p>
        <p class="paragraph"><strong>§ 2°:</strong> A rescisão antecipada não isentará o LOCATÁRIO da responsabilidade pelo pagamento dos débitos decorrentes das obrigações contratuais até a data da efetiva devolução à LOCADORA com prazo descrito na CLÁUSULA 5ª, nem das indenizações eventualmente devidas, mesmo que apurados após a referida rescisão.</p>
        <p class="paragraph"><strong>§ 3°:</strong> O descumprimento de qualquer cláusula contratual implicará resolução do contrato, independentemente de comunicação, sem prejuízo de multas e ou reparação de danos sofridos.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 11ª</p>
        <p>Em caso de inadimplemento de quaisquer das cláusulas do presente instrumento, incidirá multa de 20% (vinte por cento) sobre o valor devido, além de juros de 10% (dez por cento) ao mês e correção monetária pelo índice IGPM/FGV, sem prejuízo da multa estabelecida em cada uma delas.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 12ª</p>
        <p>As partes elegem o Foro da Comarca de Santa Maria - RS para qualquer demanda a respeito do contrato.</p>
        <p>As partes assinam este instrumento após lido e estando de acordo, com as testemunhas abaixo.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 13ª – DO TRATAMENTO DE DADOS PESSOAIS E PROTEÇÃO DE DADOS (LGPD)</p>
        <p>As partes reconhecem que o presente contrato envolve o tratamento de dados pessoais do LOCATÁRIO, nos termos da Lei nº 13.709/2018 (Lei Geral de Proteção de Dados – LGPD), comprometendo-se a cumprir integralmente a legislação aplicável.</p>
        <p class="paragraph"><strong>§ 1º</strong> O LOCADOR poderá coletar, armazenar e processar os seguintes dados do LOCATÁRIO: nome completo, CPF, RG, endereço, telefone, e-mail, informações do veículo locado e dados de geolocalização, quando necessários à proteção patrimonial, segurança do veículo, execução do contrato e prevenção de ilícitos.</p>
        <p class="paragraph"><strong>§ 2º</strong> Os dados serão utilizados exclusivamente para execução e gestão do contrato, comunicação entre as partes, cobrança de valores, cumprimento de obrigações legais e comunicação a autoridades competentes.</p>
        <p class="paragraph"><strong>§ 3º</strong> O LOCATÁRIO autoriza o compartilhamento de seus dados com terceiros estritamente necessários, incluindo autoridades de trânsito, seguradoras, empresas de rastreamento veicular, instituições financeiras e sistemas de proteção ao crédito.</p>
        <p class="paragraph"><strong>§ 4º</strong> O LOCADOR adotará medidas técnicas e organizacionais adequadas para proteção dos dados pessoais.</p>
        <p class="paragraph"><strong>§ 5º</strong> O LOCATÁRIO poderá solicitar acesso, correção ou atualização de seus dados, ressalvadas hipóteses legais de retenção.</p>
        <p class="paragraph"><strong>§ 6º</strong> Os dados poderão ser mantidos pelo prazo legal necessário, inclusive após o término do contrato.</p>
        <p class="paragraph"><strong>§ 7º</strong> Em caso de incidente de segurança, a LOCADORA adotará as medidas cabíveis, conforme a legislação vigente.</p>
    </div>
    <div class="clause">
        <p class="clause-title">CLÁUSULA 14ª – DA REMOÇÃO DA TAG DA CHAVE</p>
        <p>O LOCATÁRIO compromete-se a não remover a TAG DE IDENTIFICAÇÃO DA CHAVE do veículo locado. A remoção da tag implicará a aplicação de multa no valor de R$ 20,00 (vinte reais), a ser cobrada no momento da devolução do veículo ou descontada da caução.</p>
        <p class="paragraph"><strong>§ 1º</strong> A tag tem a finalidade de organização e controle da frota, garantindo a correta identificação da chave.</p>
        <p class="paragraph"><strong>§ 2º</strong> A remoção da tag pode gerar dificuldades administrativas e de rastreabilidade da chave.</p>
        <p class="paragraph"><strong>§ 3º</strong> A devolução da chave sem a tag será considerada descumprimento contratual, sujeitando o LOCATÁRIO à multa prevista.</p>
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
