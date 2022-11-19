function getplandetails(id) {
    console.log("TEst");
    console
    $.ajax({
        url: baseurl + 'admin/pricing/getplandetails',
        type: "POST",
        data: { "id": id },
        success: function(response) {
           console.log(response); // server response
           $('#edit_planname').val(response.plan_name);
           $('#edit_planamount').val(response.plan_amount);
           $('#edit_plantype').val(response.plan_type);
           $('#edit_planswaps').val(response.no_of_swaps);
           $('#edit_maxrental').val(response.max_rental_period);
           $('#edit_holdamount').val(response.max_charges);
           $('#edit_validmonths').val(response.validity_months);
           $('#edit_plancategory').val(response.plan_category_id);
           $('#edit_paymentmode').val(response.payment_mode_id);
           $('#edit_penaltyamount').val(response.penalty_amount);
           $('#edit_plandescription').val(response.plan_description);
        }

    });
}