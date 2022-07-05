/* Le but du script est de permettre une autocompletion du champ "place" */

$("#cp").autocomplete({
	source: function (request, response) {
		$.ajax({
			url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='cp']").val(),
			data: { q: request.term },
			dataType: "json",
			success: function (data) {
				var postcodes = [];
				response($.map(data.features, function (item) {
					// The CPs must be added in a table so as not to have several times the same
					if ($.inArray(item.properties.postcode, postcodes) == -1) {
						postcodes.push(item.properties.postcode);
						return { label: item.properties.postcode + " - " + item.properties.city, 
								city: item.properties.city,
								value: item.properties.postcode
						};
					}
				}));
			}
		});
	},
	// The city is  seized
	select: function(event, ui) {
		$('#ville').val(ui.item.city);
	}
});
$("#ville").autocomplete({
	source: function (request, response) {
		$.ajax({
			url: "https://api-adresse.data.gouv.fr/search/?city="+$("input[name='ville']").val(),
			data: { q: request.term },
			dataType: "json",
			success: function (data) {
				var cities = [];
				response($.map(data.features, function (item) {
					// The towns must be added in a table so as not to have several times the same
					if ($.inArray(item.properties.postcode, cities) == -1) {
						cities.push(item.properties.postcode);
						return { label: item.properties.postcode + " - " + item.properties.city, 
								postcode: item.properties.postcode,
								value: item.properties.city
						};
					}
				}));
			}
		});
	},
	// The CP is  seized
	select: function(event, ui) {
		$('#cp').val(ui.item.postcode);
	}
});