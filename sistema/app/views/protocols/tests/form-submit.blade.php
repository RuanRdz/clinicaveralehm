<div class="row">
	<div class="col-xs-8 col-sm-12 col-md-13 col-lg-13">
		<div class="form-group pull-right" style="width: 150px;">
			<label>
				<i class="fa fa-calendar"></i> Data Avaliação <sup>*</sup>
			</label>
			<input
				type="text"
				name="testdate"
				required="true"
				value="{{ \Input::old('testdate', isset($data) ? $data->testdate : '') }}"
				class="form-control datepicker"
				style="border-color: #5CB85C;">
		</div>
	</div>
	<div class="col-xs-8 col-sm-4 col-md-3 col-lg-3" style="padding-top: 22px;">
        <button
            type="submit"
            id="btn-submit-protocol"
            class="btn btn-primary">
            SALVAR
        </button>
    </div>
</div>
