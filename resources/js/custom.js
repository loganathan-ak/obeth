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





    function fetchFilteredOrders() {
        var keyword = $('#job_search').val();
        var status = $('#status_filter').val();
    
        if (keyword.length > 2 || status) {
            $.ajax({
                url: '/search-job',
                method: 'GET',
                data: {
                    jobname: keyword,
                    status: status
                },
                dataType: 'json',
                success: function (result) {
                    $('#orders_table_body').empty();
                    $('#filter_reset').show();
    
                    if (result.orders.length > 0) {


                        result.orders.forEach(function (order) {
                            let bgClass = '';

                            switch (order.status) {
                                case 'Pending':
                                    bgClass = 'bg-yellow-100';
                                    break;
                                case 'In Progress':
                                    bgClass = 'bg-blue-100';
                                    break;
                                case 'Completed':
                                    bgClass = 'bg-green-100';
                                    break;
                                case 'Cancelled':
                                    bgClass = 'bg-red-100';
                                    break;
                                default:
                                    bgClass = 'bg-gray-100';
                            }
                            
                            var row = `
                                <tr class="border-t ${bgClass}">
                                    <td class="px-4 py-2">${order.order_id}</td>
                                    <td class="px-4 py-2">${order.project_title}</td>
                                    <td class="px-4 py-2">${order.request_type}</td>
                                    <td class="px-4 py-2">${order.size ?? '-'}</td>
                                    <td class="px-4 py-2">${order.software ?? '-'}</td>
                                    <td class="px-4 py-2">${order.brandProfile?.brand_name ?? 'N/A'}</td>
                                    <td class="px-4 py-2">
                                        ${order.rush ? '<span class="text-red-600 font-semibold">Yes</span>' : '<span class="text-gray-500">No</span>'}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="text-blue-600 capitalize">${order.status ?? 'pending'}</span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="/orders/view/${order.id}" class="text-indigo-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            `;
                            $('#orders_table_body').append(row);
                        });
                    } else {
                        $('#orders_table_body').html('<tr><td colspan="9" class="text-center py-4 text-gray-500">No orders found.</td></tr>');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX error:', xhr.responseText);
                }
            });
        }
    }
    
    // Trigger on search input
    $('#job_search').on('input', function () {
        fetchFilteredOrders();
    });
    
    // Trigger on status dropdown change
    $('#status_filter').on('change', function () {
        fetchFilteredOrders();
    });
    


    $('#searchEnquiry').on('input', function () {
        let query = $(this).val();
        if(query.length > 2){
            $.ajax({
                url: '/search-enquiry',
                type: 'GET',
                data: { query: query },
                success: function (data) {
                    let enquiries = data.enquiries;
                    
                    $("#enquiry_body").empty();
                    $('#filter_reset').show();
                    if (enquiries.length > 0) {
                        enquiries.forEach(function(enquirie) {
                            let row = `
                                <tr> 
                                    <td class="px-4 py-2">${enquirie.name}</td>
                                    <td class="px-4 py-2">${enquirie.email}</td>
                                    <td class="px-4 py-2">${enquirie.phone}</td>
                                    <td class="px-4 py-2">${enquirie.subject}</td>
                                    <td class="px-4 py-2 max-w-xs overflow-hidden truncate" title="${enquirie.message}">
                                        ${enquirie.message.length > 50 ? enquirie.message.substring(0, 50) + '...' : enquirie.message}
                                    </td>
                                    <td class="px-4 py-2">
                                        ${enquirie.file ? `<a href="/storage/${enquirie.file}" target="_blank" class="text-blue-600 underline">Download</a>` : `<span class="text-gray-400">No File</span>`}
                                    </td>
                                    <td class="px-4 py-2">${enquirie.created_at}</td>
                                </tr>
                            `;
                            $("#enquiry_body").append(row);
                        });
                    } else {
                        $("#enquiry_body").append(`
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">No enquiries found.</td>
                            </tr>
                        `);
                    }

                }
            });
        } 
    });



    $('#adminsearchEnquiry').on('input', function () {
        let query = $(this).val();
        if(query.length > 2){
            $.ajax({
                url: '/admin-search-enquiry',
                type: 'GET',
                data: { query: query },
                success: function (data) {
                    let enquiries = data.enquiries;
                    
                    $("#enquiry_body").empty();
                    $('#filter_reset').show();
                    if (enquiries.length > 0) {
                        enquiries.forEach(function(enquirie) {
                            let row = `
                                <tr> 
                                    <td class="px-4 py-2">${enquirie.name}</td>
                                    <td class="px-4 py-2">${enquirie.email}</td>
                                    <td class="px-4 py-2">${enquirie.phone}</td>
                                    <td class="px-4 py-2">${enquirie.subject}</td>
                                    <td class="px-4 py-2 max-w-xs overflow-hidden truncate" title="${enquirie.message}">
                                        ${enquirie.message.length > 50 ? enquirie.message.substring(0, 50) + '...' : enquirie.message}
                                    </td>
                                    <td class="px-4 py-2">
                                        ${enquirie.file ? `<a href="/storage/${enquirie.file}" target="_blank" class="text-blue-600 underline">Download</a>` : `<span class="text-gray-400">No File</span>`}
                                    </td>
                                    <td class="px-4 py-2">${enquirie.created_at}</td>
                                </tr>
                            `;
                            $("#enquiry_body").append(row);
                        });
                    } else {
                        $("#enquiry_body").append(`
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">No enquiries found.</td>
                            </tr>
                        `);
                    }

                }
            });
        } 
    });



    $('#userSearch').on('input', function () {
        let query = $(this).val();
        if (query.length > 2) {
            $.ajax({
                url: '/user-search',
                type: 'GET',
                data: { query: query },
                success: function (data) {
                    let subscribers = data.subscribers;
    
                    $("#subscriber_body").empty();
                    $('#filter_reset').show();
    
                    if (subscribers.length > 0) {
                        subscribers.forEach(function(user) {
                            let statusLabel = user.status === 'active'
                                ? `<span class="text-green-600 font-medium">Active</span>`
                                : `<span class="text-red-500 font-medium">Inactive</span>`;
    
                            let row = `
                                <tr> 
                                    <td class="px-4 py-2">${user.first_name}</td>
                                    <td class="px-4 py-2">${user.last_name}</td>
                                    <td class="px-4 py-2">${user.mobile_number}</td>
                                    <td class="px-4 py-2">${user.email}</td>
                                    <td class="px-4 py-2 capitalize">${user.plan}</td>
                                    <td class="px-4 py-2">${statusLabel}</td>
                                    <td class="px-4 py-2">${new Date(user.created_at).toLocaleDateString()}</td>
                                </tr>
                            `;
                            $("#subscriber_body").append(row);
                        });
                    } else {
                        $("#subscriber_body").append(`
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">No subscribers found.</td>
                            </tr>
                        `);
                    }
                }
            });
        }
    });
    





    function adminFilteredOrders() {
        var keyword = $('#admin_job_search').val();
        var status = $('#admin_status_filter').val();
    
        if (keyword.length > 2 || status) {
            $.ajax({
                url: '/search-job',
                method: 'GET',
                data: {
                    jobname: keyword,
                    status: status
                },
                dataType: 'json',
                success: function (result) {
                    $('#orders_table_body').empty();
                    $('#filter_reset').show();
    
                    if (result.orders.length > 0) {
                        result.orders.forEach(function (order) {
                            const rowClass = order.seen ? '' : 'bg-yellow-50';
                        
                            const row = `
                                <tr class="${rowClass} border-t">
                                    <td class="px-4 py-2">${order.order_id}</td>
                                    <td class="px-4 py-2">${order.project_title}</td>
                                    <td class="px-4 py-2">${order.request_type}</td>
                                    <td class="px-4 py-2">${order.software ?? '-'}</td>
                                    <td class="px-4 py-2">${order.created_by_name ?? '-'}</td>
                                    <td class="px-4 py-2">${order.assigned_to_name ?? 'N/A'}</td>
                                    <td class="px-4 py-2">
                                        ${order.rush ? '<span class="text-red-600 font-semibold">Yes</span>' : '<span class="text-gray-500">No</span>'}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="text-blue-600 capitalize">${order.status ?? 'pending'}</span>
                                    </td>
                                    <td class="px-4 py-2 flex gap-3">
                                        <a href="/admin-vieworders/${order.id}" class="text-indigo-600 hover:underline">View</a>
                                        <a href="/admin-editorders/${order.id}" class="text-indigo-600 hover:underline">Edit</a>
                                    </td>
                                    <td class="px-4 py-2">
                                        ${order.seen 
                                            ? '<span class="text-green-600 text-xs font-medium">Seen</span>' 
                                            : '<span class="text-yellow-600 text-xs font-medium">Unseen</span>'}
                                    </td>
                                </tr>
                            `;
                            $('#orders_table_body').append(row);
                        });
                        
                    } else {
                        $('#orders_table_body').html('<tr><td colspan="9" class="text-center py-4 text-gray-500">No orders found.</td></tr>');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX error:', xhr.responseText);
                }
            });
        }
    }
    
    // Trigger on search input
    $('#admin_job_search').on('input', function () {
        adminFilteredOrders();
    });
    
    // Trigger on status dropdown change
    $('#admin_status_filter').on('change', function () {
        adminFilteredOrders();
    });
    


    
});