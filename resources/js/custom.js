$(document).ready(function(){
    $('#disable_btn').on('click', function(){
         alert('You cannot create more than 10 posts.');
    });

    $('#brand_search').on('input', function () {
        var values = $(this).val();
    
        if (values.length > 2) {
            $.ajax({
                url: '/search-brand',
                method: 'GET',
                data: {
                    brandname: values,
                },
                dataType: 'json',
                success: function (result) {

                    $('#brands_table_body').empty();
                    $('#filter_reset').show();
                    result.brands.forEach(function (brand) {
                        var row = `
                            <tr class="border-t">
                                <td class="p-3">${brand.brand_date}</td>
                                <td class="p-3 font-semibold">${brand.brand_name}</td>
                                <td class="p-3">${brand.industry ?? brand.other_industry}</td>
                                <td class="p-3">
                                    ${brand.web_address ? `<a href="${brand.web_address}" target="_blank" class="text-blue-600 underline">${brand.web_address}</a>` : ''}
                                </td>
                                <td class="p-3">${brand.brand_audience}</td>
                                <td class="p-3">${brand.brand_description ?? ''}</td>
                                <td class="p-2">
                                    ${brand.logo ? `<img src="/storage/${brand.logo}" alt="Logo" class="w-16 h-16 object-contain rounded border" />` : ''}
                                </td>
                                <td class="p-3 flex gap-3 items-center">
                                    <a href="/view-brand/${brand.id}" class="text-blue-600 underline">View</a>
                                    <a href="/edit-brand/${brand.id}" class="text-blue-600 underline">Edit</a>
                                </td>
                            </tr>
                        `;
                        $('#brands_table_body').append(row);
                    });
                },
                error: function (xhr) {
                    console.error('AJAX error:', xhr.responseText);
                }
            });
        }
    });
    
});