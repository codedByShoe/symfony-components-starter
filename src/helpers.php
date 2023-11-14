<?php



function render_template(Symfony\Component\HttpFoundation\Request $request, array $data = []): Symfony\Component\HttpFoundation\Response
{
	foreach ($data as $key => $value) {
		$request->attributes->set($key, $value);
	}
	extract($request->attributes->all(), EXTR_SKIP);
	ob_start();
	include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);
	return new Symfony\Component\HttpFoundation\Response(ob_get_clean());
}
