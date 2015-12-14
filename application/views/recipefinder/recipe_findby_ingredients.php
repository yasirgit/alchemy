<script type="text/javascript">
function submitform()
{
  document.recipe_finder_ind.submit();
}
</script>

										<div class="block-in-frame-blue">
											<div class="block-in-title-blue">
												<h2>Search for Recipe by Ingredient</h2>
											</div>
											<form action="recipefinder/search" class="signup-text" name="recipe_finder_ind" method="post">
												<fieldset>
													<div class="row">
														<div class="column-text">
															<strong>Ingredients I Have / Want to Use:</strong>
															<ul>
																<li>
																	<span class="text"><input type="text" name="ind_W1" value="<?if(!empty($ind_W1)) echo $ind_W1;?>"/></span>
																</li>
																<li>
																	<span class="text"><input type="text" name="ind_W2" value="<?if(!empty($ind_W2)) echo $ind_W2;?>"/></span>
																</li>
																<li>
																	<span class="text"><input type="text" name="ind_W3" value="<?if(!empty($ind_W3)) echo $ind_W3;?>"/></span>
																</li>
															</ul>
														</div>
														<!--div class="column-text">
															<strong>Ingredients I Don't Want:</strong>
															<ul>
																<li>
																	<span class="text"><input type="text" name="ind_NW1"/></span>
																</li>
																<li>
																	<span class="text"><input type="text" name="ind_NW2"/></span>
																</li>
																<li>
																	<span class="text"><input type="text" name="indN_W3"/></span>
																</li>
															</ul>
														</div-->
													</div>
													<div class="row row-indent">
														<label for="keywords">Additional Keywords:</label>
														<span id="keywords" class="text"><input type="text" value="<?if(!empty($extra_key)) echo $extra_key;?>" name="extra_key"/></span>
														<a href="javascript: submitform()" class="sexybutton sexyorange sexybtn align-right"><span><span>Go</span></span></a>
													</div>
												</fieldset>
											</form>
										</div>
									
