<?php
namespace App\Http\Controllers\Shop; use App\Category; use App\Product; use App\Library\Response; use Carbon\Carbon; use Illuminate\Http\Request; use App\Http\Controllers\Controller; class Coupon extends Controller { function info(Request $spfeab54) { $sp790613 = (int) $spfeab54->post('category_id', -1); $sp0e30a6 = (int) $spfeab54->post('product_id', -1); $spd5c9d2 = $spfeab54->post('coupon'); if (!$spd5c9d2) { return Response::fail('请输入优惠券'); } if ($sp790613 > 0) { $spb7fea4 = Category::findOrFail($sp790613); $spfa021e = $spb7fea4->user_id; } elseif ($sp0e30a6 > 0) { $sp71cb0c = Product::findOrFail($sp0e30a6); $spfa021e = $sp71cb0c->user_id; } else { return Response::fail('请先选择分类或商品'); } $spdacc62 = \App\Coupon::where('user_id', $spfa021e)->where('coupon', $spd5c9d2)->where('expire_at', '>', Carbon::now())->whereRaw('`count_used`<`count_all`')->get(); foreach ($spdacc62 as $spd5c9d2) { if ($spd5c9d2->category_id === -1 || $spd5c9d2->category_id === $sp790613 && ($spd5c9d2->product_id === -1 || $spd5c9d2->product_id === $sp0e30a6)) { $spd5c9d2->setVisible(array('discount_type', 'discount_val')); return Response::success($spd5c9d2); } } return Response::fail('您输入的优惠券信息无效<br>如果没有优惠券请不要填写'); } }