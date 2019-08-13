
if (Validation) { 
	Validation.addAllThese([
           
            ['validate-website', 'Please select a website.', function(v) {
                return ((v != "0"));
            }],     

			['validate-number', 'Please enter a valid number in this field.', function(v) {
                return Validation.get('IsEmpty').test(v) || (!isNaN(parseNumber(v)) && !/^\s+$/.test(parseNumber(v)));
            }],
			
        ]);
}

function mfUnsubscribeAll(checked) {
	if (checked) {
		var subscribeLists = $$('.mf-subscribe');
		subscribeLists.each(function(list) {
			list.checked = false;
		});
	}
}

function mfSubscribe(checked) {
	if (checked) {
		var unSubscribeLists = $$('.mf-unsubscribe');
		unSubscribeLists.each(function(list) {
			list.checked = false;
		});
	}	
}

function mfChangeListType(val) {
	if (val == 1) { // subscribe
	    if(!$('list_id').hasClassName('required-entry')) $('list_id').toggleClassName('required-entry');
		$('list_id').value = '';
		if($('unsub_list_id').hasClassName('required-entry')) $('unsub_list_id').toggleClassName('required-entry');
		$('unsub_list_id').value = '';
			
	}
	else if (val == 0) { // unsubscribe
		if(!$('unsub_list_id').hasClassName('required-entry')) $('unsub_list_id').toggleClassName('required-entry');
		$('list_id').value = '';
		if($('list_id').hasClassName('required-entry')) $('list_id').toggleClassName('required-entry');	
		$('unsub_list_id').value = '';
	}
}

