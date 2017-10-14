<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
function bdsBusiness($act, $typeFunc, $bds_business_id, $bds_business_menu_id, $project, $street, $road, $area_land, $area_use, $floors, $view_direction, $view_scene, $direction, $location, $geo_radius, $price_total_land, $price_unit_land, $price_house, $price_house_m2, $price_total_house_land, $transactions_deposit, $transactions_duration, $transactions_contract, $transactions_type, array $purpose_use_land, $law_land, $parallel_price, $infrastructure_lights, $infrastructure_water, $infrastructure_view, $infrastructure_land, $infrastructure_floors, $type_house, $social_05km, $social_1km, $social_3km, $social_10km, $social_street, $social_educate, $type_show, $created_time, $expiration_time, $status, $name, $transactors, $contact_name, $contact_tell, $contact_email, $is_active, $upload_img_id, $upload_img_idd, $error) {
	global $db, $tth;
	$db->table = "bds_business_menu";
	$db->condition = "bds_business_menu_id = ".$bds_business_menu_id;
	$db->order = "";
	$rows = $db->select();
	foreach($rows as $row){
		dashboardCoreAdminTwo($tth.";".$row['category_id']);
	}
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-files-o"></i> Nội dung tin đăng
				</div>
				<div class="panel-body">
					<div class="table-responsive col-lg-9 col-xs-12 tth-fcn-0">
						<div id="box_form_bds" class="basic-wizard" style="min-width: 520px;">
							<ul class="nav nav-pills nav-justified">
								<li><a href="#ztab1" data-toggle="tab"><span>Bước 1:</span></a></li>
								<li><a href="#ztab2" data-toggle="tab"><span>Bước 2:</span></a></li>
								<li><a href="#ztab3" data-toggle="tab"><span>Bước 3:</span></a></li>
								<li><a href="#ztab4" data-toggle="tab"><span>Bước 4:</span></a></li>
							</ul>
							<form id="bds_form" action="<?=$act?>" method="post" enctype="multipart/form-data">
								<input type="hidden" name="typeFunc" value="<?=$typeFunc?>" />
								<input type="hidden" name="bds_business_id" value="<?=$bds_business_id?>" />
								<input type="hidden" name="upload_img_idd" value="<?=$upload_img_idd?>">
								<div class="panel-show-error">
									<?=$error?>
								</div>

								<div class="tab-content">

									<div class="progress progress-striped active">
										<div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
									</div>

									<div class="tab-pane" id="ztab1">
										<table class="table table-hover">
											<tr class="tth-cc-info-xx">
												<td class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">Đặc điểm tin rao</span></td>
											</tr>
											<tr class="tth-cc-info-xx">
												<td width="220px" class="tth-gp-l"><label>Loại tin:</label></td>
												<td class="tth-gp-r">
													<label class="radio-inline"><input type="radio" class="type_show" name="type_show" value="1" <?=$type_show==1?"checked":"";?> required> Cần bán</label>
													<label class="radio-inline"><input type="radio" class="type_show" name="type_show" value="2" <?=$type_show==2?"checked":"";?> > Cho thuê</label> &nbsp;  &nbsp;
													<label for="type_show" class="error"></label>
												</td>
											</tr>
											<tr class="tth-cc-characteristics">
												<td class="tth-gp-l tth-gp-b"><label>Tiêu đề:</label></td>
												<td class="tth-gp-r tth-gp-b">
													<div class="col-xs-12"><input id="name" class="form-control" type="text" name="name" maxlength="255" value="<?=stripslashes($name);?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-land-type">
												<td width="220px"><label>Loại BĐS:</label></td>
												<td>
													<div class="col-md-6"><?=landType($bds_business_menu_id);?></div>
												</td>
											</tr>
											<tr class="tth-cc-project">
												<td><label>Tên dự án:</label></td>
												<td>
													<div class="col-md-6"><?=landProject($project);?></div>
												</td>
											</tr>
											<tr class="tth-cc-street">
												<td class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">Loại đường:</span></td>
											</tr>
											<tr class="tth-cc-street">
												<td class="tth-gp-l"><label>Tên đường:</label></td>
												<td class="tth-gp-r">
													<div class="col-md-6"><?=landStreet($street);?></div>
													<div class="col-md-6"><span class="tth-gp-text" style="line-height: 28px;">( Nếu chưa có tên đường thì nhập: Chưa có )</span></div>
												</td>
											</tr>
											<tr class="tth-cc-street">
												<td class="tth-gp-l tth-gp-b"><label>Chiều rộng đường:</label></td>
												<td class="tth-gp-r tth-gp-b">
													<div class="col-md-6"><?=landRoad($road);?></div>
												</td>
											</tr>
											<tr class="tth-cc-floors">
												<td><label>Số tầng:</label></td>
												<td>
													<div class="col-sm-2 col-xs-3"><input id="floors" class="form-control auto-money" type="text" name="floors" data-a-sep="." data-a-dec="," data-v-max="999" data-v-min="0" maxlength="3" value="<?=$floors;?>" required></div>
													<label for="floors" class="error"></label>
												</td>
											</tr>
											<tr class="tth-cc-view">
												<td class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">View:</span></td>
											</tr>
											<tr class="tth-cc-view">
												<td class="tth-gp-l"><label>Hướng nhìn:</label></td>
												<td class="tth-gp-r">
													<div class="col-md-6"><?=landDirection($view_direction, 'view_direction');?></div>
												</td>
											</tr>
											<tr class="tth-cc-view">
												<td class="tth-gp-l tth-gp-b"><label>Cảnh quan:</label></td>
												<td class="tth-gp-r tth-gp-b">
													<div class="col-xs-12"><input id="view_scene" class="form-control" type="text" name="view_scene" maxlength="255" value="<?=stripslashes($view_scene);?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-direction">
												<td><label>Hướng:</label></td>
												<td>
													<div class="col-md-6"><?=landDirection($direction);?></div>
												</td>
											</tr>
											<tr class="tth-cc-location">
												<td class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">Thông tin vị trí địa lý:</span></td>
											</tr>
											<tr class="tth-cc-location">
												<td class="tth-gp-l"><label>Theo địa giới hành chính:</label></td>
												<td class="tth-gp-r">
													<div class="col-lg-4 col-md-6"><?=loadCity($location);?></div>
													<div class="col-lg-4 col-md-6"><?=loadDistrict($location);?></div>
													<div class="col-lg-4 col-md-6"><?=loadLocation($location);?></div>
												</td>
											</tr>
											<tr class="tth-cc-location">
												<td class="tth-gp-l tth-gp-b"><label>Theo bán kính:</label></td>
												<td class="tth-gp-r tth-gp-b">
													<div class="col-lg-4 col-md-6"><?=geographicalRadius($geo_radius);?></div>
												</td>
											</tr>
										</table>
									</div>
									<div class="tab-pane" id="ztab2">
										<table class="table table-hover">
											<tr class="tth-cc-txt-area">
												<td width="220px" class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">Diện tích:</span></td>
											</tr>
											<tr class="tth-cc-area-land">
												<td class="tth-gp-l"><label>Diện tích đất:</label> (m<sup>2</sup>)</td>
												<td class="tth-gp-r">
													<div class="col-md-4 col-xs-6"><input id="area_land" class="form-control auto-money" type="text" name="area_land" data-a-sep="." data-a-dec="," data-v-max="9999999999" data-v-min="0.000" data-a-pad="false" maxlength="16" value="<?=$area_land;?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-area-use">
												<td class="tth-gp-l"><label>Diện tích sử dụng:</label> (m<sup>2</sup>)</td>
												<td class="tth-gp-r">
													<div class="col-md-4 col-xs-6"><input id="area_use" class="form-control auto-money" type="text" name="area_use" data-a-sep="." data-a-dec="," data-v-max="9999999999" data-v-min="0.000" data-a-pad="false" maxlength="16" value="<?=$area_use;?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-txt-area">
												<td class="tth-gp-l tth-gp-b" style="padding: 0; line-height: 0;">&nbsp;</td>
												<td class="tth-gp-r tth-gp-b" style="padding: 0; line-height: 0;">&nbsp;</td>
											</tr>
											<tr class="tth-cc-txt-price">
												<td class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">Thông tin giá BĐS:</span></td>
											</tr>
											<tr class="tth-cc-price-total-land">
												<td width="220px" class="tth-gp-l"><label>Tổng giá đất:</label> (vnđ)</td>
												<td class="tth-gp-r">
													<div class="col-md-4 col-xs-6"><input id="price_total_land" class="form-control auto-money" type="text" name="price_total_land" data-a-sep="." data-a-dec="," data-v-max="999999999999999" data-v-min="0" maxlength="20" value="<?=$price_total_land;?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-price-unit-land">
												<td class="tth-gp-l"><label>Đơn giá đất:</label> (vnđ/m<sup>2</sup>)</td>
												<td class="tth-gp-r">
													<div class="col-md-4 col-xs-6"><input id="price_unit_land" class="form-control auto-money" type="text" name="price_unit_land" data-a-sep="." data-a-dec="," data-v-max="999999999999999" data-v-min="0" maxlength="20" value="<?=$price_unit_land;?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-price-house">
												<td width="220px" class="tth-gp-l"><label>Giá nhà:</label> (vnđ)</td>
												<td class="tth-gp-r">
													<div class="col-md-4 col-xs-6"><input id="price_house" class="form-control auto-money" type="text" name="price_house" data-a-sep="." data-a-dec="," data-v-max="999999999999999" data-v-min="0" maxlength="20" value="<?=$price_house;?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-price-house-m2">
												<td class="tth-gp-l"><label>Giá nhà theo m<sup>2</sup> sàn:</label> (vnđ/m<sup>2</sup>)</td>
												<td class="tth-gp-r">
													<div class="col-md-4 col-xs-6"><input id="price_house_m2" class="form-control auto-money" type="text" name="price_house_m2" data-a-sep="." data-a-dec="," data-v-max="999999999999999" data-v-min="0" maxlength="20" value="<?=$price_house_m2;?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-price-total-house-land">
												<td width="220px" class="tth-gp-l tth-gp-b"><label>Giá tổng cả nhà và đất:</label> (vnđ)</td>
												<td class="tth-gp-r tth-gp-b">
													<div class="col-md-4 col-xs-6"><input id="price_total_house_land" class="form-control auto-money" type="text" name="price_total_house_land" data-a-sep="." data-a-dec="," data-v-max="999999999999999" data-v-min="0" maxlength="20" value="<?=$price_total_house_land;?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-txt-transactions">
												<td class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">Phương thức giao dịch:</span></td>
											</tr>
											<tr class="tth-cc-transactions">
												<td class="tth-gp-l"><label>Số tiền đặt cọc:</label> (vnđ)</td>
												<td class="tth-gp-r">
													<div class="col-md-4 col-xs-6"><input id="transactions_deposit" class="form-control auto-money" type="text" name="transactions_deposit" data-a-sep="." data-a-dec="," data-v-max="999999999999999" data-v-min="0" maxlength="20" value="<?=$transactions_deposit;?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-transactions">
												<td class="tth-gp-l"><label>Thời hạn thanh toán:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><input id="transactions_duration" class="form-control" type="text" name="transactions_duration" maxlength="255" value="<?=stripslashes($transactions_duration);?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-transactions">
												<td class="tth-gp-l"><label>Loại HĐ ký kết:</label></td>
												<td class="tth-gp-r">
													<label class="radio-inline"><input type="radio" class="transactions_contract" name="transactions_contract" value="1" <?=$transactions_contract==1?"checked":"";?> required> Góp vốn</label>
													<label class="radio-inline"><input type="radio" class="transactions_contract" name="transactions_contract" value="2" <?=$transactions_contract==2?"checked":"";?> > HĐ chuyển nhượng</label> &nbsp;  &nbsp;
													<label for="transactions_contract" class="error"></label>
												</td>
											</tr>
											<tr class="tth-cc-transactions-type">
												<td class="tth-gp-l tth-gp-b"><label>Loại giao dịch:</label></td>
												<td class="tth-gp-r tth-gp-b">
													<label class="radio-inline"><input type="radio" class="transactions_type" name="transactions_type" value="1" <?=$transactions_type==1?"checked":"";?> required> Bán tới công chứng</label>
													<label class="radio-inline"><input type="radio" class="transactions_type" name="transactions_type" value="2" <?=$transactions_type==2?"checked":"";?> > Bao sổ</label> &nbsp;  &nbsp;
													<label for="transactions_type" class="error"></label>
												</td>
											</tr>
											<tr class="tth-cc-purpose-use-land">
												<td width="220px"><label>Mục đích sử dụng phù hợp:</label></td>
												<td><?=purposeUseLand($purpose_use_land);?></td>
											</tr>
										</table>
									</div>
									<div class="tab-pane" id="ztab3">
										<table class="table table-hover">
											<tr class="tth-cc-law-land">
												<td width="220px"><label>Thông tin pháp lý:</label></td>
												<td><?=lawLand($law_land);?></td>
											</tr>
											<tr class="tth-cc-parallel-price">
												<td><label>Thông tin giá cả khu vực lân cận, hoặc dự án tương đồng:</label></td>
												<td>
													<div class="col-xs-12"><textarea id="parallel_price" class="form-control" rows="3" name="parallel_price" maxlength="1200"><?=stripslashes($parallel_price)?></textarea></div>
												</td>
											</tr>
											<tr class="tth-cc-txt-infrastructure">
												<td class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">Thông tin hạ tầng kỹ thuật:</span></td>
											</tr>
											<tr class="tth-cc-infrastructure-1">
												<td class="tth-gp-l"><label>Hệ thống điện chiếu sáng:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><input id="infrastructure_lights" class="form-control" type="text" name="infrastructure_lights" maxlength="255" value="<?=stripslashes($infrastructure_lights);?>" ></div>
												</td>
											</tr>
											<tr class="tth-cc-infrastructure-1">
												<td class="tth-gp-l"><label>Hệ thống cấp thoát nước:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><input id="infrastructure_water" class="form-control" type="text" name="infrastructure_water" maxlength="255" value="<?=stripslashes($infrastructure_water);?>" ></div>
												</td>
											</tr>
											<tr class="tth-cc-infrastructure-1">
												<td class="tth-gp-l"><label>Cây xanh, cảnh quan:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><input id="infrastructure_view" class="form-control" type="text" name="infrastructure_view" maxlength="255" value="<?=stripslashes($infrastructure_view);?>" ></div>
												</td>
											</tr>
											<tr class="tth-cc-infrastructure-2">
												<td class=" tth-gp-l" class="tth-gp-l"><label>Hạ tầng:</label></td>
												<td class="tth-gp-r"><?=infrastructureLand($infrastructure_land);?></td>
											</tr>
											<tr class="tth-cc-infrastructure-3">
												<td class="tth-gp-l"><label>Số lượng tầng:</label> <i>(mô tả kết cấu nhà)</i></td>
												<td class="tth-gp-r">
													<div class="col-sm-2 col-xs-3"><input id="infrastructure_floors" class="form-control auto-money" type="text" name="infrastructure_floors" data-a-sep="." data-a-dec="," data-v-max="999" data-v-min="0" maxlength="3" value="<?=$infrastructure_floors;?>" ></div>
												</td>
											</tr>
											<tr class="tth-cc-infrastructure-3">
												<td class=" tth-gp-l tth-gp-b"><label>Loại nhà:</label> <i>(mô tả kết cấu nhà)</i></td>
												<td class="tth-gp-r tth-gp-b"><?=typeHouseLand($type_house)?></td>
											</tr>
											<tr class="tth-cc-txt-social">
												<td class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">Thông tin hạ tầng xã hội:</span></td>
											</tr>
											<tr class="tth-cc-social-1">
												<td class=" tth-gp-l"><label>Công trình xã hội, dân sinh trong phạm vi 0,5km:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><textarea id="social_05km" class="form-control" rows="3" name="social_05km" maxlength="1200"><?=stripslashes($social_05km);?></textarea></div>
												</td>
											</tr>
											<tr class="tth-cc-social-1">
												<td class=" tth-gp-l"><label>Công trình xã hội, dân sinh trong phạm vi 1km:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><textarea id="social_1km" class="form-control" rows="3" name="social_1km" maxlength="1200"><?=stripslashes($social_1km);?></textarea></div>
												</td>
											</tr>
											<tr class="tth-cc-social-1">
												<td class=" tth-gp-l"><label>Công trình xã hội, dân sinh trong phạm vi 3km:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><textarea id="social_3km" class="form-control" rows="3" name="social_3km" maxlength="1200"><?=stripslashes($social_3km);?></textarea></div>
												</td>
											</tr>
											<tr class="tth-cc-social-1">
												<td class=" tth-gp-l"><label>Công trình xã hội, dân sinh trong phạm vi 10km:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><textarea id="social_10km" class="form-control" rows="3" name="social_10km" maxlength="1200"><?=stripslashes($social_10km);?></textarea></div>
												</td>
											</tr>
											<tr class="tth-cc-social-2">
												<td class=" tth-gp-l"><label>Mô tả đặc điểm tuyến đường:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><textarea id="social_street" class="form-control" rows="3" name="social_street" maxlength="1200"><?=stripslashes($social_street);?></textarea></div>
												</td>
											</tr>
											<tr class="tth-cc-social-2">
												<td class=" tth-gp-l"><label>Dân trí:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><textarea id="social_educate" class="form-control" rows="3" name="social_educate" maxlength="1200"><?=stripslashes($social_educate);?></textarea></div>
												</td>
											</tr>
											<tr class="tth-cc-txt-area">
												<td class="tth-gp-l tth-gp-b" style="padding: 0; line-height: 0;">&nbsp;</td>
												<td class="tth-gp-r tth-gp-b" style="padding: 0; line-height: 0;">&nbsp;</td>
											</tr>
										</table>
									</div>
									<div class="tab-pane" id="ztab4">
										<table class="table table-hover">
											<tr class="tth-cc-characteristics">
												<td class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">Thông tin về đặc điểm tin rao</span></td>
											</tr>
											<tr class="tth-cc-characteristics">
												<td class="tth-gp-l"><label>Ngày đăng:</label></td>
												<td class="tth-gp-r">
													<div class="col-md-4 col-xs-6"><input class="form-control input-datetime" type="text" name="created_time" value="<?=$created_time;?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-characteristics">
												<td class="tth-gp-l"><label>Ngày hết hạn:</label></td>
												<td class="tth-gp-r">
													<div class="col-md-4 col-xs-6"><input class="form-control input-datetime" type="text" name="expiration_time" value="<?=$expiration_time;?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-characteristics">
												<td class="tth-gp-l tth-gp-b"><label>Trạng thái giao dịch:</label></td>
												<td class="tth-gp-r tth-gp-b">
													<label class="radio-inline"><input type="radio" name="status" value="0" <?=$status==0?"checked":"";?> > Đang giao dịch</label>
													<label class="radio-inline"><input type="radio" name="status" value="1" <?=$status==1?"checked":"";?> > Đã giao dịch</label>
													<label class="radio-inline" style="color: #cccccc;"><input type="radio" name="status" value="0" disabled <?=$status==2?"checked":"";?> > Sắp hết hiệu lực</label>
													<label class="radio-inline" style="color: #cccccc;"><input type="radio" name="status" value="0" disabled <?=$status==3?"checked":"";?> > Hết hiệu lực</label>
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;</td>
											</tr>
											<tr class="tth-cc-txt-contact">
												<td class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">Thông tin liên hệ</span></td>
											</tr>
											<tr class="tth-cc-contact-radio">
												<td class="tth-gp-l"><label>Người giao dịch:</label></td>
												<td class="tth-gp-r">
													<label class="radio-inline"><input type="radio" id="transactors_0" name="transactors" onchange="onchange_contact();" value="0" <?=$transactors==0?"checked":"";?> > Nhân viên sàn</label>
													<label class="radio-inline"><input type="radio" id="transactors_1" name="transactors" onchange="onchange_contact();" value="1" <?=$transactors==1?"checked":"";?> > Trực tiếp với chính chủ</label>
												</td>
											</tr>
											<tr class="tth-cc-contact">
												<td class="tth-gp-l"><label>Tên người giao dịch:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><input id="contact_name" class="form-control" type="text" name="contact_name" maxlength="20" value="<?=stripslashes($contact_name);?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-contact">
												<td class="tth-gp-l"><label>Số điện thoại:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><input id="contact_tell" class="form-control" type="text" name="contact_tell" maxlength="20" value="<?=stripslashes($contact_tell);?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-contact">
												<td class="tth-gp-l"><label>Email:</label></td>
												<td class="tth-gp-r">
													<div class="col-xs-12"><input id="contact_email" class="form-control" type="email" name="contact_email" maxlength="255" value="<?=stripslashes($contact_email);?>" required></div>
												</td>
											</tr>
											<tr class="tth-cc-txt-area">
												<td class="tth-gp-l tth-gp-b" style="padding: 0; line-height: 0;">&nbsp;</td>
												<td class="tth-gp-r tth-gp-b" style="padding: 0; line-height: 0;">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;</td>
											</tr>
											<tr class="tth-cc-album-img">
												<td><label>Hình ảnh:</label></td>
												<td>&nbsp;</td>
											</tr>
											<tr class="tth-cc-album-img">
												<td colspan="2">
													<div class="col-xs-12">
														<input type="hidden" name="upload_img_id" value="<?=$upload_img_id?>">
														<div id="upload_img">
															<?php include(".." . DS . "file_uploader" . DS . "upload_img.php"); ?>
														</div>
														<div id="loader_img_upload">
															<?=show_img_uploader($upload_img_id);?>
														</div>
													</div>
												</td>
											</tr>
											<tr class="tth-cc-is-active">
												<td><label>Trạng thái:</label> (hiển thị)</td>
												<td>
													<label class="radio-inline"><input type="radio" name="is_active" value="0" <?=$is_active==0?"checked":"";?> > Đóng</label>
													<label class="radio-inline"><input type="radio" name="is_active" value="1" <?=$is_active==1?"checked":"";?> > Mở</label>
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<button type="submit" class="btn btn-form-primary btn-form">Đồng ý</button> &nbsp;
													<button type="reset" class="btn btn-form-success btn-form">Làm lại</button> &nbsp;
													<button type="button" class="btn btn-form-info btn-form" onclick="location.href='?<?=TTH_PATH?>=bds_business_list&id=<?=$bds_business_menu_id?>'">Thoát</button>
												</td>
											</tr>
										</table>
									</div>
								</div><!-- tab-content -->
								<ul class="pager wizard">
									<li class="previous"><a href="javascript:void(0)">Quay lại</a></li>
									<li class="next"><a href="javascript:void(0)">Tiếp tục</a></li>
								</ul>
							</form>
						</div><!-- #basicWizard -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function onchange_bsd() {
			var land_type = $("#land_type").val();
			// Set value default
			// Tab-1 -------
			$("#project").val('');
			$("#project").selectpicker('val','');
			//---
			$("#street").val('');
			$("#road").val('');
			$("#road").selectpicker('val','');
			//---
			$("#area_land").val('');
			$("#area_use").val('');
			//---
			$("#floors").val('');
			//---
			$("#view_direction").val('');
			$("#view_direction").selectpicker('val','');
			$("#view_scene").val('');
			//---
			$("#direction").val('');
			$("#direction").selectpicker('val','');
			//---
			$("#city_list").val('');
			$("#district_list").val('');
			$("#location_list").val('');
			$("#geo_radius").val('');
			// Tab-2 -------
			$("#price_total_land").val('');
			$("#price_unit_land").val('');
			$("#price_house").val('');
			$("#price_house_m2").val('');
			$("#price_total_house_land").val('');
			//---
			$("#transactions_deposit").val('');
			$("#transactions_duration").val('');
			$(".transactions_contract").attr("checked", false);
			$(".transactions_type").attr("checked", false);
			$(".purpose_use_land").attr("checked", false);
			// Tab-3 -------
			$(".law_land").attr("checked", false);
			$("#parallel_price").val('');
			//---
			$("#infrastructure_lights").val('');
			$("#infrastructure_water").val('');
			$("#infrastructure_view").val('');
			$(".infrastructure_land").attr("checked", false);
			$("#infrastructure_floors").val('');
			$(".type_house").attr("checked", false);
			$("#social_05km").val('');
			$("#social_1km").val('');
			$("#social_3km").val('');
			$("#social_10km").val('');
			$("#social_street").val('');
			$("#social_educate").val('');
			// Tab-4 -------
			$(".type_show").attr("checked", false);
			$("#name").val('');

			// Hide element
			$("#project").attr('required', false);
			$("#road").attr('required', false);
			$("#view_direction").attr('required', false);
			$(".tth-cc-project").hide();
			$(".tth-cc-street").hide();
			$(".tth-cc-area-land").hide();
			$(".tth-cc-area-use").hide();
			$(".tth-cc-floors").hide();
			$(".tth-cc-view").hide();
			$(".tth-cc-price-total-land").hide();
			$(".tth-cc-price-unit-land").hide();
			$(".tth-cc-price-house").hide();
			$(".tth-cc-price-house-m2").hide();
			$(".tth-cc-price-total-house-land").hide();
			$(".tth-cc-transactions").hide();
			$(".tth-cc-txt-infrastructure").hide();
			$(".tth-cc-infrastructure-1").hide();
			$(".tth-cc-infrastructure-2").hide();
			$(".tth-cc-infrastructure-3").hide();
			$(".tth-cc-social-2").hide();
			var project = ['1', '3', '4', '5', '6', '7', '12', '13', '15', '16', '17'];
			if(project.indexOf(land_type)!=-1) {
				$(".tth-cc-project").show();
				$("#project").attr('required', true);
			}
			var street = ['1', '2', '6', '7', '8', '9', '10', '11', '14', '15', '16', '17'];
			if(street.indexOf(land_type)!=-1) {
				$(".tth-cc-street").show();
				$("#road").attr('required', true);
			}
			var area_land = ['1', '2', '7', '9', '11', '14', '6', '8', '10', '12', '15', '16', '17'];
			if(area_land.indexOf(land_type)!=-1) {
				$(".tth-cc-area-land").show();
			}
			var area_use = ['3', '4', '5', '13', '6', '8', '10', '12', '15', '16', '17'];
			if(area_use.indexOf(land_type)!=-1) {
				$(".tth-cc-area-use").show();
			}
			var floors_view = ['3', '4', '5', '13'];
			if(floors_view.indexOf(land_type)!=-1) {
				$(".tth-cc-floors").show();
				$(".tth-cc-view").show();
				$("#view_direction").attr('required', true);
			}
			var price_land = ['1', '2', '7', '9', '11', '14', '6', '8', '10', '12', '15', '16', '17'];
			if(price_land.indexOf(land_type)!=-1) {
				$(".tth-cc-price-total-land").show();
				$(".tth-cc-price-unit-land").show();
			}
			var price_house = ['6', '8', '10', '12', '15', '16', '17', '3', '4', '5', '13'];
			if(price_house.indexOf(land_type)!=-1) {
				$(".tth-cc-price-house").show();
			}
			var price_house_m2 = ['3', '4', '5', '13'];
			if(price_house_m2.indexOf(land_type)!=-1) {
				$(".tth-cc-price-house-m2").show();
			}
			var price_land_house = ['6', '8', '10', '12', '15', '16', '17'];
			if(price_land_house.indexOf(land_type)!=-1) {
				$(".tth-cc-price-total-house-land").show();
			}
			var price_land_house = ['6', '8', '10', '12', '15', '16', '17'];
			if(price_land_house.indexOf(land_type)!=-1) {
				$(".tth-cc-price-total-house-land").show();
			}
			var transactions = ['1', '3', '4', '5', '12', '13', '17'];
			if(transactions.indexOf(land_type)!=-1) {
				$(".tth-cc-transactions").show();
			}
			var infrastructure_1 = ['1', '2', '6', '7', '12', '14', '15', '16', '18'];
			if(infrastructure_1.indexOf(land_type)!=-1) {
				$(".tth-cc-txt-infrastructure").show();
				$(".tth-cc-infrastructure-1").show();
			}
			var infrastructure_2 = ['3', '4', '5', '13', '17'];
			if(infrastructure_2.indexOf(land_type)!=-1) {
				$(".tth-cc-txt-infrastructure").show();
				$(".tth-cc-infrastructure-2").show();
			}
			var infrastructure_3 = ['6', '8', '10'];
			if(infrastructure_3.indexOf(land_type)!=-1) {
				$(".tth-cc-txt-infrastructure").show();
				$(".tth-cc-infrastructure-3").show();
			}
			var social = ['8', '9', '10', '11'];
			if(social.indexOf(land_type)!=-1) {
				$(".tth-cc-social-2").show();
			}
		}

		function onLoad_bsd() {
			var land_type = $("#land_type").val();
			// Hide element
			$("#project").attr('required', false);
			$("#road").attr('required', false);
			$("#view_direction").attr('required', false);
			$(".tth-cc-project").hide();
			$(".tth-cc-street").hide();
			$(".tth-cc-area-land").hide();
			$(".tth-cc-area-use").hide();
			$(".tth-cc-floors").hide();
			$(".tth-cc-view").hide();
			$(".tth-cc-price-total-land").hide();
			$(".tth-cc-price-unit-land").hide();
			$(".tth-cc-price-house").hide();
			$(".tth-cc-price-house-m2").hide();
			$(".tth-cc-price-total-house-land").hide();
			$(".tth-cc-transactions").hide();
			$(".tth-cc-txt-infrastructure").hide();
			$(".tth-cc-infrastructure-1").hide();
			$(".tth-cc-infrastructure-2").hide();
			$(".tth-cc-infrastructure-3").hide();
			$(".tth-cc-social-2").hide();
			var project = ['1', '3', '4', '5', '6', '7', '12', '13', '15', '16', '17'];
			if(project.indexOf(land_type)!=-1) {
				$(".tth-cc-project").show();
				$("#project").attr('required', true);
			}
			var street = ['1', '2', '6', '7', '8', '9', '10', '11', '14', '15', '16', '17'];
			if(street.indexOf(land_type)!=-1) {
				$(".tth-cc-street").show();
				$("#road").attr('required', true);
			}
			var area_land = ['1', '2', '7', '9', '11', '14', '6', '8', '10', '12', '15', '16', '17'];
			if(area_land.indexOf(land_type)!=-1) {
				$(".tth-cc-area-land").show();
			}
			var area_use = ['3', '4', '5', '13', '6', '8', '10', '12', '15', '16', '17'];
			if(area_use.indexOf(land_type)!=-1) {
				$(".tth-cc-area-use").show();
			}
			var floors_view = ['3', '4', '5', '13'];
			if(floors_view.indexOf(land_type)!=-1) {
				$(".tth-cc-floors").show();
				$(".tth-cc-view").show();
				$("#view_direction").attr('required', true);
			}
			var price_land = ['1', '2', '7', '9', '11', '14', '6', '8', '10', '12', '15', '16', '17'];
			if(price_land.indexOf(land_type)!=-1) {
				$(".tth-cc-price-total-land").show();
				$(".tth-cc-price-unit-land").show();
			}
			var price_house = ['6', '8', '10', '12', '15', '16', '17', '3', '4', '5', '13'];
			if(price_house.indexOf(land_type)!=-1) {
				$(".tth-cc-price-house").show();
			}
			var price_house_m2 = ['3', '4', '5', '13'];
			if(price_house_m2.indexOf(land_type)!=-1) {
				$(".tth-cc-price-house-m2").show();
			}
			var price_land_house = ['6', '8', '10', '12', '15', '16', '17'];
			if(price_land_house.indexOf(land_type)!=-1) {
				$(".tth-cc-price-total-house-land").show();
			}
			var price_land_house = ['6', '8', '10', '12', '15', '16', '17'];
			if(price_land_house.indexOf(land_type)!=-1) {
				$(".tth-cc-price-total-house-land").show();
			}
			var transactions = ['1', '3', '4', '5', '12', '13', '17'];
			if(transactions.indexOf(land_type)!=-1) {
				$(".tth-cc-transactions").show();
			}
			var infrastructure_1 = ['1', '2', '6', '7', '12', '14', '15', '16', '18'];
			if(infrastructure_1.indexOf(land_type)!=-1) {
				$(".tth-cc-txt-infrastructure").show();
				$(".tth-cc-infrastructure-1").show();
			}
			var infrastructure_2 = ['3', '4', '5', '13', '17'];
			if(infrastructure_2.indexOf(land_type)!=-1) {
				$(".tth-cc-txt-infrastructure").show();
				$(".tth-cc-infrastructure-2").show();
			}
			var infrastructure_3 = ['6', '8', '10'];
			if(infrastructure_3.indexOf(land_type)!=-1) {
				$(".tth-cc-txt-infrastructure").show();
				$(".tth-cc-infrastructure-3").show();
			}
			var social = ['8', '9', '10', '11'];
			if(social.indexOf(land_type)!=-1) {
				$(".tth-cc-social-2").show();
			}
		}


		function onchange_contact() {
			var transactors = $('input[name=transactors]');
			var val_transactors = transactors.filter(':checked').val();
			$(".tth-cc-contact").hide();
			$("#contact_name").val('');
			$("#contact_tell").val('');
			$("#contact_email").val('');
			if(val_transactors == 0) {
				$(".tth-cc-contact").hide();
			} else {
				$(".tth-cc-contact").show();
			}
		}

		function onchange_calculate(mod) {
			var area_land = $("#area_land").autoNumeric('get');
			var area_use = $("#area_use").autoNumeric('get');
			var price_total_land = $("#price_total_land").autoNumeric('get');
			var price_unit_land = $("#price_unit_land").autoNumeric('get');
			var price_house = $("#price_house").autoNumeric('get');
			var price_house_m2 = $("#price_house_m2").autoNumeric('get');
			var price_total_house_land = $("#price_total_house_land").autoNumeric('get');
			//------------------------------------
			if(mod=='unit_land') {
				var cr_unit_land = ((parseFloat(price_total_land)/parseFloat(area_land))*1);
				price_unit_land = Math.round(cr_unit_land);
				if(price_unit_land>0) {
					return price_unit_land;
				} else {
					return 0;
				}
			} else if(mod=='area_land') {
				area_land = ((parseFloat(price_total_land)/parseFloat(price_unit_land))*1);
				if(area_land>0) {
					return area_land;
				} else {
					return 0;
				}
			} else if(mod=='total_house_land') {
				price_total_house_land = ((parseFloat(price_total_land)+parseFloat(price_house))*1);
				if(price_total_house_land>0) {
					return price_total_house_land;
				} else {
					return 0;
				}
			} else if(mod=='house') {
				price_house = ((parseFloat(price_total_house_land)-parseFloat(price_total_land))*1);
				if(price_house>0) {
					return price_house;
				} else {
					return 0;
				}
			} else if(mod=='house_m2') {
				var cr_house_m2 = ((parseFloat(price_house)/parseFloat(area_use))*1);
				price_house_m2 = Math.round(cr_house_m2);
				if(price_house_m2>0) {
					return price_house_m2;
				} else {
					return 0;
				}
			} else if(mod=='area_use') {
				area_use = ((parseFloat(price_house)/parseFloat(price_house_m2))*1);
				if(area_use>0) {
					return area_use;
				} else {
					return 0;
				}
			}
		}
		$(document).ready(function (e) {
			$('#area_land').bind('blur focusout keypress keyup', function () {
				var val = onchange_calculate('unit_land');
				$("#price_unit_land").autoNumeric('set', val);
			});
			$('#price_total_land').bind('blur focusout keypress keyup', function () {
				var val = onchange_calculate('unit_land');
				var val2 = onchange_calculate('total_house_land');
				$("#price_unit_land").autoNumeric('set', val);
				$("#price_total_house_land").autoNumeric('set', val2);
			});
			$('#price_unit_land').bind('blur focusout keypress keyup', function () {
				var val = onchange_calculate('area_land');
				$("#area_land").autoNumeric('set', val);
			});
			$('#price_house').bind('blur focusout keypress keyup', function () {
				var val = onchange_calculate('total_house_land');
				var val2 = onchange_calculate('house_m2');
				$("#price_total_house_land").autoNumeric('set', val);
				$("#price_house_m2").autoNumeric('set', val2);
			});
			$('#price_total_house_land').bind('blur focusout keypress keyup', function () {
				var val = onchange_calculate('house');
				$("#price_house").autoNumeric('set', val);
			});
			$('#price_house_m2').bind('blur focusout keypress keyup', function () {
				var val = onchange_calculate('area_use');
				$("#area_use").autoNumeric('set', val);
			});
			$('#area_use').bind('blur focusout keypress keyup', function () {
				var val = onchange_calculate('house_m2');
				$("#price_house_m2").autoNumeric('set', val);
			});
		});

		jQuery(document).ready(function(){
			onLoad_bsd();
			<?php
			if($transactors==0) echo 'onchange_contact();';
			?>

			$('select.selectpicker').on('change', function(){
				if($(this).val()!="") {
					$(this).valid();
				}
			});
			var $validator = jQuery("#bds_form").validate({
				ignore: ':not(select.selectpicker:hidden, select:visible, input:visible, textarea:visible)'
			});
			$('#box_form_bds').bootstrapWizard({
				tabClass: 'nav nav-pills nav-justified nav-disabled-click',
				onTabClick: function(tab, navigation, index) {
					return false;
				},
				'nextSelector': '.next',
				'previousSelector': '.previous',
				onNext: function(tab, navigation, index) {
					var $valid = $('#bds_form').valid();
					if(!$valid) {
						$validator.focusInvalid();
						return false;
					}
					var $total = navigation.find('li').length;
					var $current = index+1;
					var $percent = ($current/$total) * 100;
					jQuery('#box_form_bds').find('.progress-bar').css('width', $percent+'%');
				},
				onPrevious: function(tab, navigation, index) {
					var $total = navigation.find('li').length;
					var $current = index+1;
					var $percent = ($current/$total) * 100;
					jQuery('#box_form_bds').find('.progress-bar').css('width', $percent+'%');
				},
				onTabShow: function(tab, navigation, index) {
					var $total = navigation.find('li').length;
					var $current = index+1;
					var $percent = ($current/$total) * 100;
					jQuery('#box_form_bds').find('.progress-bar').css('width', $percent+'%');
					$('html, body').animate({scrollTop: parseInt($('#box_form_bds').offset().top) }, 0);
				}
			});
		});
		//-----|end-form|-----
		$('.input-datetime').datetimepicker({
			mask:'39/19/9999 29:59',
			lang:'vi',
			format:'<?=TTH_DATETIME_FORMAT?>'
		});
	</script>
<?php
}

function sortAcsStreet(){
	global $db;
	$db->table = "street";
	$db->condition = "";
	$db->limit = "";
	$db->select();
	return $db->RowCount;
}