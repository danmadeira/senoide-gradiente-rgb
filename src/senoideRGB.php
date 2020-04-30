<?php

ini_set('precision', 8);

$options = array('options' => array('default' => 50, 'min_range' => 10, 'max_range' => 500));
$ncores = filter_input(INPUT_GET, 'ncores', FILTER_VALIDATE_INT, $options);

$altura = 576;
$faixa = round($altura * 1.77777778 / $ncores);
$largura = $faixa * $ncores;

$frequencia = 2 * M_PI / $ncores;
$amplitude = 127.5;
$centro = 128;
$faseR = 0;
$faseG = 2 * M_PI / 3;
$faseB = 4 * M_PI / 3;

$imagem = imagecreatetruecolor($largura, $altura);
$posicao = 0;

for ($incremento = 0; $incremento < $ncores; $incremento++) {
    $red   = floor(sin($frequencia * $incremento + $faseR) * $amplitude + $centro);
    $green = floor(sin($frequencia * $incremento + $faseG) * $amplitude + $centro);
    $blue  = floor(sin($frequencia * $incremento + $faseB) * $amplitude + $centro);
    $cor = imagecolorallocate($imagem, $red, $green, $blue);
    imagefilledrectangle($imagem, $posicao, 0, $posicao + $faixa - 1, $altura - 1, $cor);
    $posicao = $posicao + $faixa;
}

header("Content-Type: image/png");
header('Content-Disposition: inline; filename="rainbow.png"');
imagepng($imagem);
imagedestroy($imagem);

