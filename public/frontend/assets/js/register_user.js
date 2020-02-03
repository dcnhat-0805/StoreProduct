$(document).ready(function () {
    Commons.loadAddressSelectBox();
   // function loadDistrictByCityId(cityId) {
   //     $.ajax({
   //         url : '/account/ajaxGetDistricts',
   //         dataType : 'JSON',
   //         type : 'GET',
   //         data : {
   //             city_id : cityId
   //          },
   //         success : function (data) {
   //             $('.district').html(data)
   //         }
   //     });
   // }
   //
   // function loadWardsByDistrictId(districtId) {
   //     $.ajax({
   //         url : '/account/ajaxGetWards',
   //         dataType : 'JSON',
   //         type : 'GET',
   //         data : {
   //             district_id : districtId
   //          },
   //         success : function (data) {
   //             $('.wards').html(data)
   //         }
   //     });
   // }
   //
   // $('.jsSelectCity').on('change', function () {
   //    let cityId = $(this).val();
   //
   //    if (cityId) {
   //        loadDistrictByCityId(cityId);
   //    }
   // });
   //
   // $(document).on('change', '.jsSelectDistrict', function () {
   //    let districtId = $(this).val();
   //
   //    if (districtId) {
   //        loadWardsByDistrictId(districtId);
   //    }
   // });
});
