$(function () {

    // Ip Number
    var cleave = new Cleave('.ipnumber', {
        delimiter: '.',
        blocks: [3, 3, 3, 3],
        uppercase: true
    })

     // Mac Number
    var cleave = new Cleave('.macnumber', {
        delimiter: ':',
        blocks: [2, 2, 2, 2, 2, 2],
        uppercase: true
    })

    //Initialize Select2 Elements
    $('.select2').select2()

    // // //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
})