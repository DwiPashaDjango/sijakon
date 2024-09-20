/*
 *                  LARAVEL TABLE
 *
 * @author          M. Nur Wahyu
 * @email           m.nur.wahyu1974@gmail.com
 * @address         DUSUN KRAJAN II, Desa Jombang, Kec. Jombang, Kab. Jember, Jawa Timur, Indonesia.
 * @description     Laravel Table merupakan plugin jQuery untuk merender output JSON suatu response API Laravel atau response API yang sama persis dengna Laravel ke dalam bentuk HTML Table.
 * @version         0.0.1
 *
 * Jika ada yang mengalami kendala atau bug pada plugin ini, silahkan contact support ke email diatas yang tertera.
 * Siapapun juga boleh ikut serta dalam pengembangan plugin laravel table ini.
 * Plugin ini saya sebarkan secara publik dan boleh diakses oleh siapapun tanpa dikenai biaya.
 */

/*
 * Inisialisasi jQuery.
 */
(function( $ ) {

 /*
  * Set global variabel elementId, responsiveElement, defaultOptions dan globalOptions.
  */
 let elementId,
     responsiveElement,
     defaultOptions,
     globalOptions = []

 /*
  * Menggabungkan seluruh function dalam jQuery.
  */
 $.fn.extend({

     /*
      * Fungsi untuk implementasi Laravel Table ke Table HTML.
      * Contoh implementasi Laravel Table ke html:
      *
      * Standart parameter.
      * $(ElementID).laravelTable({
      *      url: `http://localhost:8000/api/employee`,
      *      columns: [
      *          {
      *              data: "name"
      *          },
      *          {
      *              data: "gender"
      *          },
      *          {
      *              data: "position"
      *          },
      *          {
      *              data: "phone",
      *              html: e => {
      *                  return `${ (`${e.phone}`).replace(`62`, `( +62 ) `) }`
      *              }
      *          },
      *          {
      *              data: "address"
      *          },
      *          {
      *              data: "email"
      *          },
      *          {
      *              data: null,
      *              sort: false,
      *              html: e => {
      *                  return `
      *                      <div class="btn-group">
      *                          <button type="button" class="btn btn-primary btn-sm">Edit</button>
      *                          <button type="button" class="btn btn-danger btn-sm">Hapus</button>
      *                      </div>`                  `
      *              }
      *          }
      *      ]
      * })
      *
      * Komplit parameter.
      * $(ElementID).laravelTable({
      *      url: `http://localhost:8000/api/employee`,
      *      customClass: `table-sm`,
      *      data: {
      *          param1: `nilai1`,
      *          param2: `nilai2`,
      *          param3: `nilai3`,
      *      },
      *      loading: {
      *          show: "true"
      *      },
      *      pagination: {
      *          show: "true",
      *          type: `default`,
      *          customClass: `pagination-sm`
      *      },
      *      limit: {
      *          show: "true",
      *          data: [
      *              10,
      *              25,
      *              50,
      *              100
      *          ],
      *          customClass: `form-select-sm`
      *      },
      *      search: {
      *          show: "true",
      *          placeholder: `Search column...`,
      *          customClass: `form-control-sm`
      *      },
      *      columns: [
      *          {
      *              data: "name"
      *          },
      *          {
      *              data: "gender"
      *          },
      *          {
      *              data: "position"
      *          },
      *          {
      *              data: "phone",
      *              html: e => {
      *                  return `${ (`${e.phone}`).replace(`62`, `( +62 ) `) }`
      *              }
      *          },
      *          {
      *              data: "address"
      *          },
      *          {
      *              data: "email"
      *          },
      *          {
      *              data: null,
      *              sort: false,
      *              html: e => {
      *                  return `
      *                      <div class="btn-group">
      *                          <button type="button" class="btn btn-primary btn-sm">Edit</button>
      *                          <button type="button" class="btn btn-danger btn-sm">Hapus</button>
      *                      </div>`                  `
      *              }
      *          }
      *      ]
      * })
      */
     laravelTable: function( customOptions = {} ) {

         /*
          * Set variabel baru.
          * Variabel table memiliki nilai id table yang akan di definisikan Laravel Table.
          * Variabel elementId memiliki nilai id dari element table.
          * Dan variabel responsiveElement memiliki nilai element dengan class table-responsive.
          */
         table = `table#${ $(this).attr(`id`) }`
         elementId = $(this).attr(`id`)
         responsiveElement = $($(this).parent())

         /*
          * Set value untuk variabel globalOptions dengan key elementId untuk mendefinisikan multi tabel.
          */
         globalOptions[elementId] = {

             /*
              * Parameter url digunakan untuk request ke API URL yang diminta.
              */
             url: customOptions.url ? customOptions.url : ``,

             /*
              * Parameter method digunakan untuk method pemanggilan API, method tergantung dari API ada POST, GET, PUT, PATCH dan DELETE.
              * Default parameter value GET.
              */
             method: customOptions.method ? customOptions.method : `GET`,

             /*
              * Parameter headers digunakan untuk request ajax atau xmlHttpRequest ke API.
              */
             headers: {

                 /*
                  * Key Accept dengan nilai application/josn, digunakan untuk output response API yaitu JSON.
                  */
                 "Accept": "application/json",

                 /*
                  * Key Content-Type dengan nilai application/json, digunakan untuk parameter dikonversikan ke delam bentuk JSON.
                  */
                 "Content-Type": "application/json",

                 /*
                  * Menambahkan key headers jika ada tambahan headers.
                  * Untuk metode set nilai headers yaitu menggunakan array
                  * {
                  *      key1: `nilai`,
                  *      key2: `nilai`,
                  *      key3: `nilai`,
                  *      key[n]...
                  * }
                  */
                 ...customOptions.headers
             },

             /*
              * Parameter customClass digunakan untuk mengubah style atau gaya table.
              * Parameter boleh diisi atau tidak.
              */
             customClass: customOptions.customClass ? customOptions.customClass : ``,

             /*
              * Parameter data digunakan untuk parameter yang akan direquest kan ke API.
              * Untuk metode set nilai data yaitu menggunakan array
              * {
              *      key1: `nilai`,
              *      key2: `nilai`,
              *      key3: `nilai`,
              *      key[n]...
              * }
              */
             data: customOptions.data ? customOptions.data : {},

             /*
              * Parameter loading digunakan untuk pengaturan loading component.
              */
             loading: {

                 /*
                  * Parameter loading di dalamnya juga memiliki parameter yaitu show.
                  * Default parameter show yaitu true.
                  * Parameter show hanya memiliki 2 nilai, yaitu true atau false.
                  */
                 show: customOptions.loading && customOptions.loading.show ? customOptions.loading.show : true
             },

             /*
              * Parameter pagination digunakan untuk pengaturan pagination.
              */
             pagination: {

                 /*
                  * Parameter show digunakan untuk menentukan apakah pagination ditampilkan atau tidak.
                  * Default parameter show yaitu true.
                  * Parameter show hanya memiliki 2 nilai, yaitu true atau false.
                  */
                 show: customOptions.pagination && customOptions.pagination.show ? customOptions.pagination.show : true,

                 /*
                  * Parameter type digunakan untuk menentukan style atau gaya pagination yang akan ditampilkan.
                  * Default parameter type yaitu default.
                  * Parameter show hanya memiliki 2 nilai, yaitu default atau simple.
                  */
                 type: customOptions.pagination && customOptions.pagination.type ? customOptions.pagination.type : `default`,

                 /*
                  * Menambahkan custom class jika ingin mengubah style pagination.
                  */
                 customClass: customOptions.pagination && customOptions.pagination.customClass ? customOptions.pagination.customClass : ``
             },

             /*
              * Parameter limit digunakan untuk pengaturan limit data yang akan ditampilkan.
              * Parameter limit di dalam nya memiliki parameter pendukung, yaitu show, data dan customClass.
              */
             limit: {

                 /*
                  * Parameter show digunakan untuk menentukan form select limit ditampilkan atau tidak.
                  * Parameter show memiliki nilai default, yaitu true.
                  * Mengambil nilai parameter limit show, parameter ini memiliki default value yaitu true.
                  */
                 show: customOptions.limit && customOptions.limit.show ? customOptions.limit.show : true,

                 /*
                  * Parameter data adalah parameter yang digunakan untuk nilai - nilai limit data yang akan ditampilkan.
                  */
                 data: customOptions.limit && customOptions.limit.data ? customOptions.limit.data : [
                     10,
                     25,
                     50,
                     100
                 ],

                 /*
                  * Parameter customClass digunakan jika ingin merubah style atau gaya form limit data.
                  */
                 customClass: customOptions.limit && customOptions.limit.customClass ? customOptions.limit.customClass : ``
             },

             /*
              * Parameter search digunakan untuk pengaturan search form.
              * Adapun parameter pendukung, yaitu show, placeholder dan customClass.
              */
             search: {

                 /*
                  * Parameter show digunakan untuk menampilkan search form atau tidak.
                  * Parameter show ini hanya memiliki 2 nilai, yaitu true atau false.
                  */
                 show: customOptions.search && customOptions.search.show ? customOptions.search.show : true,

                 /*
                  * Parameter placeholder digunakan untuk mengisi label input search.
                  */
                 placeholder: customOptions.search && customOptions.search.placeholder ? customOptions.search.placeholder : `Cari ...`,

                 /*
                  * Parameter customClass digunakan untuk mengubah style atau gaya search form.
                  */
                 customClass: customOptions.search && customOptions.search.customClass ? customOptions.search.customClass : ''
             },

             /*
              * Parameter columns digunakan untuk mendefinisikan columns atau data yang akan ditampilkan ke table.
              * Cara pengisian parameter columns, yaitu:
              *
              * [
              *      {
              *          data: `column`,
              *          sort: true,
              *          html: function(e) {
              *              return `html-code`
              *          }
              *      }
              * ]
              *
              * Parameter data digunakan untuk mendefinisikan key data yang ada pada response API.
              * Parameter sort digunakan untuk mendefinisikan bahwa kolom tersebut menggunakan sort data atau tidak.
              * Parameter html digunakan untuk custom output yang dihasilkan ke dalam tabel, jika parameter html ini digunakan maka parameter data set value ke null.
              */
             columns: customOptions.columns ? customOptions.columns : []
         }

         /*
          * Set value variabel defaultOptions.
          */
         defaultOptions = globalOptions[elementId]

         /*
          * Menambahkan class laravel-table dan custom class ke dalam table.
          */
         $(this).addClass(`laravel-table ${ defaultOptions.customClass }`)

         /*
          * Menambahkan class laravel-table_responsive dan custom class, juga menambahkan id { elementId }-laravel-table_responsive
          */
         responsiveElement.addClass(`laravel-table_responsive`).attr(`id`, `${ elementId }-laravel-table_responsive`)

         /*
          * Mengambil nilai thead > th dari table dan merubah ke dalam bentuk format html baru.
          */
         $.each($(`${ table } thead tr th:not([colspan])`).get(), function (index, value) {

             /*
              * Mengambil nilai html dari element th.
              */
             let innerHTML = value.innerHTML

             /*
              * Mengubah default element th ke dalam bentuk default th laravel table.
              */
             $(this).html(`<div class="d-flex flex-row justify-content-between align-items-center" style="vertical-align: baseline;">${ innerHTML } <div class="d-flex flex-column p-0"><i class="d-block bi bi-caret-up"></i><i class="d-block bi bi-caret-down"></i></div></div>`).attr(`style`, `vertical-align: bottom; text-align: center;`).attr(`data-index`, index)
         })

         /*
          * Menambahkan data sort ke dalam element thead > th dan menghapus data sort jika kolom tersebut parameter sort bernailai false.
          */
         $.each($(`${ table } thead tr th:not([colspan])`).get(), function (index, value) {

             /*
              * Mengambil nilai text dari element thead > th.
              */
             let innerText = $(value).text()

             /*
              * Menambahkan variabel baru dengan nama sort dan memili nilai default true.
              */
             let sort = true

             /*
              * Mengambil parameter sort dari parameter columns dan di konversikan kedalam bentuk perulangan karena parameter sort dalam bentuk array.
              */
             $.each(defaultOptions.columns, function (indexColumns, valueColumns) {
                 /*
                  * Jika parameter sort yang di ambil dari parameter kolom memiliki nilai false maka variabel sort berubah menjadi false.
                  */
                 if ((valueColumns.sort == false || valueColumns.sort == "false") && indexColumns == index) {
                     sort = false
                 }
             })

             /*
              * Menambahkan data-sort ke dalam thead > th.
              */
             $(this).attr(`data-sort`, sort)

             /*
              * Menghapus data-sort jika parameter kolom sort false.
              */
             if (sort == false) {
                 $(this).html(innerText).attr(`style`, `vertical-align: middle;`).removeAttr(`data-index`)
             }
         })

         /*
          * Set variabel baru dengan nama limitContentOption
          */
         let limitContentOption = ``

         /*
          * Memasukkan nilai dari parameter limit data ke dalam element option.
          */
         $.each(defaultOptions.limit.data, function (index, value) {
             limitContentOption += `<option value="${ value }">${ value }</option>`
         })

         /*
          * Menghapus element laravel-table_filter.
          */
         $(`#${ elementId }-laravel-table_filter.laravel-table_filter`).remove()

         /*
          * Menambahkan variabel baru dengan nama limitContent.
          * Didalam variabel limitContent memiliki nilai yaitu element select baru yang digunakan untuk melimit data pada saat memunculkan data pada tabel.
          * Nilai options diambil dari variabel limitContentOption
          */
         let limitContent = defaultOptions.limit.show == true || defaultOptions.limit.show == "true" ? `<select class="form-select laravel-table_limit ${ defaultOptions.limit.customClass }">${ limitContentOption }</select>` : ``

         /*
          * Menambahkan variabel baru dengan nama searchForm.
          * Didalam variabel searchForm memiliki nilai yaitu sebuah element form baru yang digunakan untuk request mencari data yang diinput oleh user.
          */
         let searchForm = defaultOptions.search.show == true || defaultOptions.search.show == "true" ? `
         <form class="laravel-table_search">
             <div class="form-group">
                 <div class="input-group ${ defaultOptions.search.customClass }">
                     <input type="text" name="search" id="search" autocomplete="off" class="form-control search" placeholder="${ defaultOptions.search.placeholder }" />
                     <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                 </div>
             </div>
         </form>` : ``

         /*
          * Menambahkan element baru ke dalam HTML.
          * Didalam element baru ini terdapat limit dan search form yang di ambil dari variabel limitContent dan searchForm.
          */
         $(`${ table }`).parent().parent().prepend(`
             <div class="d-flex justify-content-between mb-2 laravel-table_filter" id="${ elementId }-laravel-table_filter">
                 <div>${ limitContent }</div>
                 <div class="w-25">${ searchForm }</div>
             </div>
         `)

         /*
          * Meneruskan fungsi ini ke fungsi _API dan _Func.
          */
         $(this)._API()._Func()

         /*
          * Mengembalikan nilai this element.
          */
         return this
     },

     /*
      * Fungsi untuk memanggil API.
      * Adapun parameter customRequest yang didapat dari fungsi sebelumnya.
      */
     _API: function(customRequest = {}) {

         /*
          * Menambahkan variabel element yang mempunyai nilai id element.
          */
         let element = this[0].id

         /*
          * Menambahkan variabel limit yang mempunyai nilai element limit data.
          */
         let limit = $(`#${ element }-laravel-table_filter .laravel-table_limit`).val()

         /*
          * Menambahkan variabel options dengan nilai dari variabel globalOptions.
          */
         let options = globalOptions[element]

         /*
          * Mengubah nilai data dari parameter globalOptions.
          */
         globalOptions[element]['data'] = {

             /*
              * Mengambil nilai data dari variabel globalOptions sebelumnya.
              */
             ...globalOptions[element].data,

             /*
              * Set limit data
              */
             limit: limit ? limit : options.limit.data[0],

             /*
              * Set search value
              */
             search: $(`#${ element }-laravel-table_filter form.laravel-table_search input`).val(),

             /*
              * Menambahkan parameter custom data.
              * Adapun cara pengisiannya, yaitu dengan array.
              * {
              *      key1: `nilai`,
              *      key2: `nilai`,
              *      key3: `nilai`,
              *      key[n]...
              * }
              */
             ...customRequest.data
         }

         /*
          * Call ajax jQuery untuk request ke API yang diminta.
          */
         $.ajax({
             url: customRequest.url ? customRequest.url : options.url,
             method: options.method,
             headers: options.headers,
             data: options.data,
             xhrFields: {
                 withCredentials: true
             },
             async: true,
             beforeSend: function() {

                 /*
                  * Mendefinisikan jika parameter loading > show sama dengan true maka menampilkan loading data.
                  */
                 if (options.loading.show == true || options.loading.show == "true") {
                     $(`#${ element }-laravel-table_responsive`).append(`
                         <div class="laravel-table_loading">
                             <img src="data:image/gif;base64,R0lGODlhyADIAPcAAAAAAAk7VwBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQFxsQRzsgd1swt3tA54tBF6tRd9tx2BuSGDuiWFuyiHvC2JvjGMvzWOwDmQwjySwz6Tw0CUxEmZx1+lzW6t0nu11oW62Yu+25XD3pvH4KLL46nO5a3R5rHT57jX6cTe7dDk8NXn8uTw9ujy9+rz+O31+e/2+vL3+/b5/Pj7/Pj7/Pj7/Pn7/fn8/fn8/f7+/v7+/v7+/v7+/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////yH/C05FVFNDQVBFMi4wAwEAAAAh+QQJBABFACwAAAAAyADIAAAI/gCLCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz697Nu3dUFiVAUKAAogQL3y82CFjOfPmGF7tJNJ/O/ERu6dSzm7j9Irt3CtA3/qYQTjwFZeXes2/QWAMEdRA1IrNIn/44RvfZQUTGTp86CYwp0GfeY/j1N51+FxWYH0gpXHCBfWpNYCB1F2AkYXoUgHSBc2xdOCFzFV7kYXYTaMjhWgp+iKBFKR7IoIMQpsXfhwL8d1GA6Q3o2Hw0LhdjRS0ut+Jj6H24XkbtvRdfZN3RGJ5G400wAQg6SmbCh9vhdiV9E2SZW3LePecbCySAICUIJPzo25pstunmm3DGKeecdNZp55145qnnnnz26eefgAYq6KCEFmrooYgmquiijDbq6KOQRirppJRWaumlmGaq6aacdurpp6CGKuqopJZq6qmopqrqqqy26uqrDrDGKuustNZq66248hQQACH5BAkEAEMALAAAAADIAMgAhwAAAABwsABwsABxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQFxsQJysQRzsgVzsgd0sgl1swp2swx3tA14tA54tBF5tRd9tx6BuSeGvC+LvziPwTuSwj6Twz+Twz+UxEKVxUiZxlKeyWCmzmus0XKw1Hq01n22136314C32IG42IK52YS62Ye72ou+25LB3ZzH4aTL46zQ5bXV6L7a6sXe7dHl8N3r9OXw9+rz+O71+fT5+/v9/v39/v3+/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+AIcIHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3s3bKA4YKkCAUAEDR+8hNUAMWM58OYgbu1U0n85cRW4S1LMPIHFbuvbs1jX+7gh+4cLwHZJrfP8OHWONC9Qv1IisfH12EBhnrJ/vGIf978ZVtAN8312AXmMw/KcdDBaZ8F94HQU33FoOKkgdhBPVtx5+ETaHoVkaWsgchxRZ8N8FHoVI4lkhijjAihKZaJ8FKTYHY1kVurjchxG1eJ9H3u2oVoI6LsdgRUF+x2NGEi5Jln9FDhAgRTvIqF0GBzbm4383SqTed/w59qWL7V1Ug5XMZRDmY0n+d2RG44FggQXnUYadgtzh1mZ2b+J2w5Yvlrnbb00Wd9yhiCaq6KKMNuroo5BGKumklFZq6aWYZqrpppx26umnoIYq6qiklmrqqaimquqqrLbq6qswsMYq66y01mrrrbjmquuuvPbq66/ABivssMQWa+yxyCar7LLMNuvss9BGK+20hQUEACH5BAkEAHIALAAAAADIAMgAhwAAAAsvRBFwpgBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQFxsQRzsgp2swx3tA54tBB5tRV8tht/uCCCuiWFuyqIvS+LvzSNwDiQwTySwkKVxEeYxkuax0+cyFKfylagy1ujzF+lzWKnzmWpz2qr0W+u0nWx1Hq01n6214K52Ye72oy+3JDA3ZLB3ZbE35nG4JzH4Z7J4Z/J4qHK4qPL46XM5KfN5KnP5azQ5q7R5rHT57PU6LXV6LnX6bvZ6r3a6r7a67/b68Hc68Pd7Mff7crh7s7j79Pm8dnp89zr9N/t9ePv9ufx9+ny+O30+e71+e/2+u/2+u/2+u/2+u/2+vD2+vH3+vT5+/r8/fv9/fz9/v7+/v7+/v7+/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+AOUIHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3r0zzJTfU8LwJjhkxYDjyFcQ4S2FBPLnyElIyT0EunXkQ25Xv849u8YtOlz+nDghQ8cWyVK4qx8wHaOSENZDKInsfP11EhhlrJfxeLv9695RpMR/8zVm3H/XrVDRFvDZF4JwHIXRgwsu9ADhWWEgqF5FOWiYQ4QNHvcgWulpeF17ErmgIX8b9WBdDySaeCJFJ2h4AkcqQsdiSFdcMVSJMj6HYkQ1InjjRjk+tyNIPf4YJHRDQpSkfUti5CJ0MGL45HMcegjicyOideCTClLE4H9hbiShDDJYqJZ/QQY40YD2FdhYfTLid5F+6lW5GJAmRilgiMjJJxmc/8l50RY5yDCeDDlcGBmi6ilKW3PrScdbcdatYOluUoQq6HCklmrqqaimquqqrLbq6qtUsMYq66y01mrrrbjmquuuvPbq66/ABivssMQWa+yxyCar7LLMNuvss9BGK+201FZr7bXYZqvtttx26+234IYr7rjklmvuueimq+667Lbr7rvwHhQQACH5BAkEAFQALAAAAADIAMgAhwAAAAZMcwFwrwBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQJysQl2sw95tRN7thV8tx6BuSGDuiSEuyeGvCuIvS6KvjGMvzSNwDePwTySwz2Twz+Twz+Twz+UxEGVxEaXxk2byFWgylykzWOnz2qr0XGv03iz1X6314G42IW62Yi8242/3JHB3ZjF353I4Z3I4Z/J4qHK4qPL46bN5KnP5a7R5rPU6LrY6sLc7Mjg7szi787j8NHl8NTn8djp8trq893s9OHu9ebx9+rz+O31+fD2+vT5+/f6/Pn7/fz9/v7+/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+AKkIHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3q0ziIsUI0akcBGEt0AbFwYoX678wg3dSzgwn76cw5LbQSZQ3z5gQnGNR27+rAi+4sYRyUu0c98+4TpGGdxlRN6wfj2Hi0tG1B/hnrGN+vXZYJF+AI7gmAUArndBRfAlOIB8He3gggs7qBWEg+t9F9ERGHZ3nkb5MccfWi10uF0LE/3XoYAaESgiWiiYSN0KE61gIo0Z7cBdhWa5KKNyBkrkY4JBYlTiiSJtcJ9QQ8pYJERN7qfRkdShGNIGGwwV44/LoVDjjRrpuB2PZVHJJYQRqYghixk1+SRZF3KpnIYQcYjhBB9mFOJyI6KFIJcWMIghmhvt0EILZKKlpoxsThTldG8qRp+MWVq0J3d9NpaeiRb0Z1GD001AqGPZYWgBnRcdYcN4I6xgQ559kS0xaX0beGqbDX9SZ0GjugXRAgrBodACqsYVa+yxyCar7LLMNuvss9BGK+201FZr7bXYZqvtttx26+234IYr7rjklmvuueimq+667Lbr7rvwxivvvPTWa++9+Oar77789uvvvwAHLPDABBds8MEIJ6zwwgw37PDDEEdsUEAAIfkECQQAagAsAAAAAMgAyACHAAAAFxsdWWBkEnu2AHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxA3KxBnSyC3azDni0Dni0D3i1EXm1E3u2G3+4I4S7Koi9No7BPJLDQZXER5jGTpzIWqPMXaTNX6bOYqfOZqnQa6zRba3ScK/TcrDUeLPVe7XWfbbXf7fXgLjYgrnZhbraiLzbi77bjb/cjr/cjsDckMDdkcHdlMPel8Tfmsbgncjhps3kq9DlrtHmrtLmsNLnstPnttbovNnqwNvrxN7syuHu0OTw1Obx1+ny3Ov03uz03+313+313+313+314O314+/25vH36fL47fX58Pb69Pj7+Pv9+vz9/P3+/v7+/v7+/v7+/v7+/v7+/v7+////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CP4A1QgcSLCgwYMIEypcyLChw4cQI0qcSLGixYsYM2rcyLGjx48gQ4ocSbKkyZMoU6pcybKly5cwY8qcSbOmzZs4c+rcybOnz59AgwodSrSo0aNIkypdyrSp06dQo0qdSrWq1atYs2rdyrWr169gw4odS7as2bNo06pdy7at27dw48qdS7eu3bt48+rdy7ev37+AAwseTLiw4cOIEytezLix48eQI0ueTLmy5cuYM2vezLmz58+gQ4seTbq06dOoU6tezbq169ewY8ueTbu27du4c+vendMKEBUlCBAooQKIFd5WWghfzpxAi+O4lYRoTp1ACCUdnQBp0QKIE8pFqv6LJ1BE4w3xOCIrGT8eu0UrKNijgM7YynT21UPQl2gfv/X9iSnnX3UtVBTfgCh09IUSOOCgxBdpWTHgeAA6dN6EBACxkXTMhfDdWUBgWJ2GEokonEbrVfdhWQeauJwKEjnh4ooVfXEfdSFAWFZwLi6XYEQhmkiiRSmK555HX8ggg45A9dicRAKKKANGF4p3A0gyCDdlUE4yB6WLW1pUZXVXfpQlAWH+xKOTJUgUpIhDVlRkdUcqqCSTP6nQJQEwRiSjiTRS9AUI4oGAp1hv9hjnQy6iKF6gYknYZYUNjenfokQSuhwIkI4VpYkFUtQifj9utOANNzyolhWaiggCpZUOserfq47NOWGdE8EnH6yIhYdheRlZuhymjSnR6ngg4IqRdtx5Z1ly7D2H3G88Emccb9hmq+223Hbr7bfghivuuOSWa+656Kar7rrstuvuu/DGK++89NZr77345qvvvvz26++/AAcs8MAEF2zwwQgnrPDCDDfs8MMQRyzxxBRXbPHFGGes8cYcd+zxxyCHLPLIJGMVEAAh+QQJBABnACwAAAAAyADIAIcAAAAHRGcJbaYAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbECcrEGdLIJdrMMd7QOeLQOeLQOeLQPeLUQebUSerYXfbcbf7gfgbklhbsxjL85kMI9ksM/lMRDlsVHmMZLmsdQnclRnslTn8pXoctcpM1fps5ip85lqc9oq9BtrdJzsdR5tNZ8tdd+ttd/t9d/t9iAuNiEutmJvduQwN2Yxd+cx+GeyOGeyOGfyeKhyuKiy+OlzOSqz+Wy0+e41+m82erA3OvG3+3O4/DV5/La6vPc6/Te7PTe7PTf7fXh7vXl8Pbo8vfr8/jt9fnu9fnv9vrv9vrx9/ry9/v2+vz8/f7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gDPCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz696d8wqSFysGDFjxAskV3l5oCF/OfAANLx+jIEESxfITEc2zDxDxZOOR4M1X/jCRfES7+QFHMHp5cX7AC+iOn7Q3373i9fnb6y/2gh1/cxHwScSff9sFmJFvP/xgnFrKEdgcDRSx5+ALG/mQ3Q9oXeGgdsdFVN6GA4yHEQrmoXDWhyAul15E4G24AkYWnueDWRKmKByFEdk4wEUaztdhR1ck+ONPLdr4IkRR6FhdRSieJyJHPQo3ZE86LieChzquSFGM7c3YEZcDePlTlcKFgKWNWk4EpnliVsicEEEVmeKRDyVp45IUNWnekxtFGcKUPNVoI44Q6cgjfoAe6IMPie6kJ4hpOiSnf3RWtGZzbYoVpY2NKsREinxWRKJ2Jp7VYIoQTiQofoTCmF2mrGR5EUKKIRgIkawE1grlEYse0alY8oGo30RPzDpfCMMu9mh7kU60XnvvRVYsfshuxMSk4lGWXHvPRXfEEXhadsURwIUQAnG+8qbuuuy26+678MYr77z01mvvvfjmq+++/Pbr778AByzwwAQXbPDBCCes8MIMN+zwwxBHLPHEFFds8cUYZ6zxxhx37PHHIIcs8sgkl2zyySinrPLKLLfs8sswxyzzzDTXbDNWAQEAIfkECQQAaAAsAAAAAMgAyACHAAAAAHCwAHCwAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAXGxBHOyBnSyB3SyCHWzDHe0D3m1EXq1FHu2F323Gn+4HYG5IIK6IoO7JoW8KYe9K4i9LYm+L4u/Moy/NI3AOI/BO5HCQZXERpjGSprHT53JVaDKWaPMXaTNYKbOYqjPZanQaavRba3Sbq7ScK/TcrDTdbLVebTWfLXXfrbXf7fYhLrZir3bk8Lem8fgosviq8/lstPnudfpvdnqvtvrv9vrv9vrwNzrwtzsxt/tyeDuzOLvzuPv0OTw0ubx1efy2enz2+rz3ez03uz03uz03+313+314e714+/25vH36fP47PT57fX57vX57vX57/b67/b68Pb68Pf68/j79fn8+fz9/v7+/v7+/v7+/v7+/v7+/v7+////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CP4A0QgcSLCgwYMIEypcyLChw4cQI0qcSLGixYsYM2rcyLGjx48gQ4ocSbKkyZMoU6pcybKly5cwY8qcSbOmzZs4c+rcybOnz59AgwodSrSo0aNIkypdyrSp06dQo0qdSrWq1atYs2rdyrWr169gw4odS7as2bNo06pdy7at27dw48qdS7eu3bt48+rdy7ev37+AAwseTLiw4cOIEytezLix48eQI0ueTLmy5cuYM2vezLmz58+gQ4seTbq06dOoU6tezbq169ewY8ueTbu27du4c+verTPKDhsqVNjYEYW3wCAjBihfrnxEkI5RYHhg7gFGcclbTDDfvtzEloxbVP5wZ67i++Mt08dz92C+YhIJ6plLSOIYffzx7N3Dv798PscoQ9hgwxDtoaUdf9yZQNEW+yGonAQFVhQedzBEOFYQDo73nETiZbicChglgYF6GNBnVnIeMjeCRFGkyNx1C44YHwYWftWiiy9GBAOOysFgUYf3+egRgEPA+NMOPC63Q0Tp4ehBRTciWKNFNjBnQ1BVJjnAlRBpOUBFGDq4oUZRLmckT0DyKORDXlaUJYJcahQmc2P2lCaOIHappZsZxpnRnMvVydObPPrZUJsUAXqfoBeVqdyZOyGp5ZIQNenikxQ5Gt+UfC6XQ1CapgjpQjuqaVGpQX4URRBBjMoTisU4rhhRqA666tAWMpLIaVeKeshoQ3c6mKdFIpJoolkHpqjgRAymSCN4qC5XYVr2eZgfRe9l6N9GWwQhYBC7ilUtgtfqh2CJkGWHoHfgBUteuIghp55z0ElHnXWX+QaccMQZ5++/AAcs8MAEF2zwwQgnrPDCDDfs8MMQRyzxxBRXbPHFGGes8cYcd+zxxyCHLPLIJJds8skop6zyyiy37PLLMMcs88w012zzzTjnrPPOPPfs889ABy300EQXbfTRSCet9EIBAQAh+QQJBAB4ACwAAAAAyADIAIcAAAAQEBBPX2gJdrMFdLIFdLICcrEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEDcrEGdLILd7QOeLQQebUSerUUe7YXfbccgLkig7sohrwtib4zjcA5kMI9ksM/lMRClsVImcZQnclXoctcpM1fpc1kqM9qq9FvrtN1sdR6tNZ/t9eAt9iCudmFu9qKvduOv9yQwN2QwN2Rwd2Twt6Vw9+YxeCcx+GfyeKiyuKkzOOpzuWu0eay0+e21ei52Om82eq+2uq+2uq+2uq/2+u/2+u/2+u/2+u/2+vB3OvE3uzH3+3J4O7K4e7M4u/O4+/P5PDQ5PDS5fDU5vHW6PLZ6fPb6/Pd6/Te7PTg7fXi7vbl8Pfo8vfq8/js9Pnt9fnu9fnu9fnv9vrv9vrv9vrw9/rz+Pv6/P38/f79/v7+/v7+/v7+/v7+/v7+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gDxCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz697d04qVkWh8yBguwweay0pWfDjA/MCHFUo6KkHRvPoBFNElWylh3XqJ3xjR/rjo3t1FZCUayFvXkL0imhDqu4c4zlHJjRtP2iqJT769xPf8yafRF9x590VaVqQXYHUagCfReAtaZ95FPijYnQZCoFVghM2VMNF+HFrnn0Q+LJhhWSCG2NyIDVGnYnMoVPSFhfFpcKBHSuQ31AovNrdCRGj0WB19Em0YoIcc3aCgBjcItZyQH0RUopDM+UCRikl21yRQVDIXUQxdHhDDhyqyWBGNzGkAlBVh3ugQmF2OKdENKm6JUYoi/sRmlw42BCeVckZEZ4h2XoRndWbmFOaXYQYK0aEBJjoRmgeoCdSTPUYJ0ZRUWjkRlhsNWl2hPfEo5I8QBdklkREZyR+S1aEuSWpPkHIoaUIu9hgjRTMuaONHSty6k6sRwvoolcIuxGl8J5aVoIq/TgShihNaJASlaTZrVq3xJasQfCGGMCCxJbiJFnq+eqsQgBHOJ9196oa13avmWjRtfNWep1x1z8Xr0HTqYZeZb8D5EMPBMRjH28IMN+zwwxBHLPHEFFds8cUYZ6zxxhx37PHHIIcs8sgkl2zyySinrPLKLLfs8sswxyzzzDTXbPPNOOes88489+zzz0AHLfTQRBdt9NFIJ6300kw37fTTUEct9dRUV2311TEFBAAh+QQJBABpACwAAAAAyADIAIcAAAADXZAAcLAAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEDc7IJdbMNd7QOeLQPeLQPeLQPeLQPebUQebURebUTe7YXfbccgLkhg7olhbsqiL0vi781jsE7kcI+k8NBlcRFl8VJmsdMm8hPnclQnclSnspVoMtbo8xjqM9qq9Fwr9N3s9V6tNZ9ttd+ttd+tteAt9iBuNiFutmIvNqMvtySwt6XxN+dyOGhyuKozuSv0ua11ei52Om82eq+2urA2+vB3OvF3u3I4O3L4u/P5PDT5vHX6PLa6vPd6/Te7PTf7fXf7fXg7fXg7fXi7vbl8Pfq8/ju9fnu9fnv9vrv9vrw9vrx9/ry+Pv1+fv6/P3+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gDTCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz694dtsqQFyo8eFDxYkgVzF6U7NihxItHLzUGSJ9OvYbzyTtGUJc+YsfGJx62/osf4OGJxypKlBx3+8TE+Okm1lsc8v79EI1VXoSf7uGFfLRD7FcfefdVpMSA75l30Q8CbucBEGmBhyB//0HkRYMTSufBdRS5MOELaLmXoXQmUBTdiNvVUNEPI/7wURUVArUDitN5F1EVNIrHIURVYFifBzFatMN+HtgYlHY5jiARfTlSV2BEHqLowkYiUlciUF40Kd2ODUWp5QBTStQBjR5oNON4RvZ0oJZKRJTCl9KlIBGOOXJJ0ZjjlfnTmU2m2RCeX+oJ0Zo0tnkRne8FiROfOfrJEKBadiARoSgaahGi4yl6E6WFugnnAHLe2KSdE0FKnaQ/ZaklqQp5qWWY/hGZiiCqGDFKnaM7IUmjkhEx+eWTELk6IawYVQmfULZmiOtCmI46URWyvteBphPtgGcHy/Jk7IRXSnRikypSxGKGLp5HLU9PRDvetBR5oe6AHbDqkLDjEVvWEO9O1wGwEj3RpIIW/aBuB+WmVcW228WHka8Z8ltRFS5A2oEL546VnXjdfZevdB0AvBF6zc2V3HIhdwTdgNbx5sUQLqTQQQcpuDCEvLzVbPPNOOes88489+zzz0AHLfTQRBdt9NFIJ6300kw37fTTUEct9dRUV2311VhnrfXWXHft9ddghy322GSXbfbZaKet9tpst+3223DHLffcdNdt99145633C9589+3334AHflJAACH5BAkEAG4ALAAAAADIAMgAhwAAAABwsABwsABxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQJysQRzsgd1swp2swx3tA13tA54tA54tA94tA95tRB5tRJ6tRZ9txt/uCGDuieGvC2JvjWOwDuRwj6Twz+UxEGVxEeYxkqax02byE+cyFCdyVGeyVOfylehy1ukzGCmzmOoz2ap0Gmr0W6u0nay1Xy113+32IK52Ye72o6/3JPC3prG4J7I4aTM46nO5azQ5q7R5q/S5rDT57XV6LrY6b/b68Pd7MXe7cfg7crh7s3j79Dk8NPm8dXn8tjp89zr9N7s9N7s9N7s9N/t9d/t9eHu9eTw9ufx9+rz+Oz0+e31+e71+e71+e/2+u/2+vD2+vP4+/T5+/b6/Pj7/fz9/v7+/v7+/v7+/v7+/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+AN0IHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3h22yg4TIgYMEGFiRxXeVWIIX858QIzjH798mVuFCA4TJnAQga5xCIfm4Af+cBiyscr17+Kzc1f7pUb4ATWmY/Tx/r2PjN7fj197BET9ASAccdEQ/71HXkVfsFDgACzIZ9YRCwonIEVVoBfhchysF5GCEbLwURNNGPWFfxGC4GBEyl3YXAwU0afigRlVwaFwLGjok3sq1jBRFSqGZyNDFfaYYUY+WIghjD7x2OMAPy60w5LN7SARDlDigFGQ4Q35E4FLIumQCVAy52FEYC5pAkYzhjemT1QuaWVEwYUpnAgSbQAlCBgtCFSZPZ4ZkZzMRfSFnCdK1MSCIfrEp4p+QgTocoISatGhBSbaU5s9vglRnHLSGZGdS+J5kZ5bQullQ4tC2ehDqUa4KkX6aYK3Zk9K9tikQk8CKmVEmKqoaUVVgAreBrfihOOFOkpUa5jFIhRsjxsU2qKwy20wIVAjXmgiRSlCyeJEXF54KrBp1kgUhBFeqyy1FxJbUaz1zboRiEj191+AA5pqUYILNsjesc3FR2SP92E0BLvVjntWFUNcl90QzUZ08IIbKLzjdaBukJ20jiX333MgSaeZb8DNyYJxvKWs8sost+zyyzDHLPPMNNds880456zzzjz37PPPQAct9NBEF2300UgnrfTSTDft9NNQRy311FRXbfXVWGet9dZcd+3112CHLfbYZJdt9tlop6322my37fbbcMct99x01w1TQAAh+QQJBABpACwAAAAAyADIAIcAAAAPFhoOa6EAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEBcbEDcrEKdrMOeLUTe7YXfbcaf7gcgLkegbkegbkfgroig7onhrwrib0uir4yjL82j8E7kcI+k8M+k8NAlMRDlsVHmMZKmsdNm8hPnMhQnclSnspYostdpM1ip85rrNFurtJwr9NxsNN1stR5tNZ8ttd/t9iEudmPwN2ZxeCeyOGiy+Orz+Wz1Oe41+m92urA2+vC3OzE3uzI4O3L4u/N4+/O4+/P5PDQ5fDT5vHX6PLa6vPd7PTj7/bq8/jt9fnu9fnu9fnu9fnw9vrz+Pv4+/z4+/35/P36/P38/f7+/v7+/v7+/v7+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gDTCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz694tFokPFsBZ+EDCW6CQDQOSK0++YYjHIjZYnDjBwkYRylROLN+u/AQVjUJE/nBPLsJ52yc+ZIgQIcPHk41PkI/nvuG9xS0y5i+XsUXtlhzz5dDfRVTIp992G3xH0RbaHdjdgBw9YZ9RT4innwgTUmSCg+OdUFF+HConw0ZIsLAcC8QNtYWFB4oAoURChDieEBPFKKNyNF70X4Av+gRgiDlUZOCNzE3E4o0iYPRjgEE9QWSGDyFBJHdQMlTElMpdV5GUDqbokw9E+jARmFgqJyZENZQ5QJAVbeggC0CBKOOIEpmo5gB0PmQnlnBWJCNQR3KYZJ13DtDnQ27yWZGTIVaZU6AODhrRnmUe6lCiU1oaEaMcOoqTnCHmCRGlWIraEKk3ahrRnz+RKeOZ/hG5WiasDqVZJpsUocqdqjpx2uhEXKrpaUJXlqklRcHq56WPMuIq0ZBESgoRpIIqeaCzPq0oaI8Q2YhljhF5eyO4Fe04noBDVdjisJdiacKHRNZAIqUoGmUud+gSCK2DCZaL6YEmcIuRhEuhpx577sG373z16QjqfDUInBgV/45ngoIYhTefCORCdtzGHWdURA7BsZDDsZUZDFx77Bbn8sswxyzzzDTXbPPNOOes88489+zzz0AHLfTQRBdt9NFIJ6300kw37fTTUEct9dRUV2311VhnrfXWXHft9ddghy322GSXbfbZaKet9tpst+3223DHLffcdNdt99145z11AUAAIfkECQQAXAAsAAAAAMgAyACHAAAAAHCwAHCwAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAXGxBXSyCXazDni0E3u2GH64HYC5HoG5H4K6IIK6I4S7J4a8Koi9Loq+M43AOJDCPpPDQpXFR5jGTJvIT53JU5/KWqPMYabOZ6rQba3Sc7DUeLPVfLXXfrbXf7fYgbjYg7nZhbraibzbjb/ckMDdk8Lel8Tfmsbgocrip83kq9Dlr9Lns9Tot9fpvNnqwNvrxd7ty+HuzuPv0OTw0+bx2Onz3ez04u725fD36PL46/P47PT57vX57vX57vX57/b67/b67/b68Pb68vj7+Pv9/v7+/v7+/v7+/v7+/v7+/v7+////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CP4AuQgcSLCgwYMIEypcyLChw4cQI0qcSLGixYsYM2rcyLGjx48gQ4ocSbKkyZMoU6pcybKly5cwY8qcSbOmzZs4c+rcybOnz59AgwodSrSo0aNIkypdyrSp06dQo0qdSrWq1atYs2rdyrWr169gw4odS7as2bNo06pdy7at27dw48qdS7eu3bt48+rdy7ev37+AAwseTLiw4cOIEytezLix48eQI0ueTLmy5cuYM2vezLmz58+gQ4seTbq06dOoU6tezbq169ewY8ueTbu27du4c+vePfYIEB48gBwRSQRIjRpAiFyGAsPDgOfQPcCAwpG5BujQNUyfzIMC9u8DNP7w0JjDO3joFHJEfnH+PAyMKNqDR/ERCnWlRFaEeB5ihXKN7MkH3gsWxSfgd/RpxEMJ14VXwnhGBQjeexjxcOB5EEqUw4XgqXcRFCW0V8J9QjknnwcfmsdhdiQ+BIWKKw5AQYsSvSjgjEJJKB+BFekY4wA1SORjjDxSFOKBJQRFxIr/TWTij8+hGFEGUGZXkYUcZtiTCiuqQNERVWI33ENLhvlckxEdeWGSP+3HYQgUAWHmc0BAJOecdU5EJYcaAPUjRViamadDNcwJ5ERQ/EijTn9OFGiYgzZU6JxB1qhomyvCOdGdgtppaKQQ7XlhBkBxyaGXE4E555gOlWkmmv4QqYkkUK4eCCtET0IpZahmkgroilr2NOSAFg3LYaUQGXthkRPJKuJQuYK3K0VQiBpjBosyZCOUOFa0bXseZCtse8xeWWWwD20IpYcWgSiiuD4RoYKbIahwa48/lhuRgSsmmNGCe2bwIFvKfqevRPwe6G918J7Fg7XgZYAuReXdyC5kUNQQ7QAe1NBwjS9APEAGL3zMmG9ApMzqR8UdlxxvMMcs88w012zzzTjnrPPOPPfs889ABy300EQXbfTRSCet9NJMN+3001BHLfXUVFdt9dVYZ6311lx37fXXYIct9thkl2322WinrfbabLft9ttwxy333HTXbffdeOet9wXefCsUEAAh+QQJBAB5ACwAAAAAyADIAIcAAAAPFhoycZUuir4tir4uir4tir4sib4qiL0nhrwlhbsig7shg7oggroggrofgrodgLkaf7gYfbcWfLcUe7YSerYQebUPebUPeLQOeLQOeLQOeLQOeLQOeLQNd7QKdrMGdLIBcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEEc7IUfLcqiL03j8E8ksM+k8M+k8M+k8M+k8NAlMREl8VGmMZJmcdMm8hOnMhRnslUn8pao8xfps5lqc9qq9FtrtJxsNN1sdR4s9V8ttd/t9eBuNiFutmJvduMvtyQwN2Swt6Xxd+dyOGiyuKmzeSrz+Wx0+e11ei51+m92urA2+vD3ezH3+3L4u7O4+/P5PDP5PDQ5PDR5fDU5/HX6PLa6vPe7PTj7/bo8vft9fnu9fnz+Pv4+/z8/f7+/v7+/v7+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gDzCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz696teMsSH8B9LNmCmQyU4D6gkPH4xIKI59CfW4BC+UuD6NEHfNFIZgD27yIG/iyHfAQ89iMYyTg3j93C+IxXfj8XjmXpmzcfh7DHTsSi+v3fuYfRGz6YRwR+RZFBxHUiNEDEGhuVB2B06FHk3YTYDXDRF+uZZ8F2Q1HRIXQWUJHRFxhiB2JET6T43RMVvTGihwgCRcV+Jl70gIvQaSjRBTxGZ0FFBWLYH1BrzNgehBWRESR07zm0xZPRESfRFTxeAZR+AA5hUYtUwgjRElRCt8REZLp45k87AtiARUU+6UNEcVI5p0R1TnhnT2+kCGeZezqUZ5CBPvTkT31i+KeddJY530SHsjnhA4vK2aijhQrKY6Y6cbmflxWB+aSYD6VZ5poRmYohqj2tASR78xcwSZGTVEbZ0JSOWhkRli5qaSOOGLXJo48RvfrkBUSmCGpQVBgL3QU5bvjkihCJGiSpEr3hrHkX1BjUGkO0+cAQsmIkYYoVTnThsBtui90F1JblaZf+ubvfBbZORKB5Q3h71rnspdukveDhu1F8RQrnK1tfrJthvE06bJ54lJHxBHJP5IvREwRDy5tAviE33Mckl2zyySinrPLKLLfs8sswxyzzzDTXbPPNOOes88489+zzz0AHLfTQRBdt9NFIJ6300kw37fTTUEct9dRUV2311VhnrfXWXHft9ddghy322GSXbfbZaKet9tpst+322ysHBAAh+QQJBABoACwAAAAAyADIAIcAAAAAcLAAcLAAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEBcbEDcrEEc7IGdLIIdbMKdrMMd7QOeLQPebURerUTe7YXfbcaf7gdgLkegbkfgbkggroig7omhrwqiL0uir4vi78yjMA3j8E8ksNClcRGmMZMm8hQnclUoMpYostao8xdpM1epc1epc1gps5jqM9nqtBqrNFsrdJurtJysNN3s9V/t9eHvNqMvtyOv9yPwN2Rwd2Vw9+cx+GhyuKnzeSr0OWu0eav0uey0+e21ui72erA2+vE3ezI4O7N4u/T5vHW5/LY6fPc6/Te7PTf7fXg7fXg7fXj7/bo8vfs9Pnt9fnt9fnu9fnw9vrz+Pv2+vz4+/z6/P39/v7+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gDRCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz696duEoQFSYGDDChIkgV3lVoCF/OfACN45O9BKERfDiNIF42IsnQvPuADEg4/jKZbsLEdSZumYTwPiAEeoxE2LMnktFLC/Ytsqf1okP+ch36UYSEf+yFZ9F2/oGXVg4ELpdDRVVw12BzGUA30YATGigUf9WZAOBGTEy43HsSKSdiczRQ5IWEDWYQ4E9PrNdcCE/UJ6OIIbzoUBUnemchRPed2EJQXtw4o44TAdGjcEBIpOSSzDUZUYhL1vgTg/I9eJGJPaYYkQpQMqeCk1BK6VN17JmAEZonqhmRkVC6CRGXJ3rpU4MYhTmARHoyJxGbIo75E54X6clnn8L9CaWgZ/onZ0WATsjoQ3Au+ahDdIpoZ09YsqelRZlOuKlDYPY5qUNP9mhmT0WylyNG6qmeuCqqiM7aEJU9WgljpTTa2OOrEfHY548PBSnikBvm0GEOSFaE64QkRhSqpiqySKCLZ3VK4KcSRQhlhRVh2KCGZXmhrafNPiTuieReaG13CqqlnqvRVhTfifRhZB9+6ZYLBHXCmQdEvxIheG27Fz3xrwoq0ACErpIl599zyAEBXMAqAEEsbxx37PHHIIcs8sgkl2zyySinrPLKLLfs8sswxyzzzDTXbPPNOOes88489+zzz0AHLfTQRBdt9NFIJ6300kw37fTTUEct9dRUV2311VhnrfXWXHft9ddghy322GSXbfbZaA8UEAAh+QQJBABiACwAAAAAyADIAIcAAAAAb68AcLAAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEEc7IHdLILd7QNeLQOeLQPeLQPeLQOeLQOeLQOeLQPeLQPebURerUUe7Yaf7gegbkjhLsnhrwrib0uir4vir4wi78zjcA3j8E7kcJElsVKmsdVoMtbo8xepc1fps5hp85mqtBrrNFwr9N0sdR5tNZ8tdd9ttd/t9eAt9iCudmHu9qNv9yUwt6Yxd+bx+CfyeKgyuKgyuKiy+OlzOOpzuWs0Oat0eav0uaw0uez1Oi31um82erE3ezJ4O7O4+/S5fHX6PLe7PTk8Pbo8vfr8/ju9fnu9fnu9fnv9vrv9vrv9vrv9vrv9vrv9vrv9vrw9vry9/v5/P36/P3+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gDFCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz696dmAoPFSVChCihggcV3lRoXBjAvDnzCzSOc6RChIYLFzSISI+rRMlHJcud/ot/7j1jExXjmato0paKihDOQ6jYfnFH+PTiL+zAuAO/8/1qDXFffkdgBJ5/6V1QHkUzIOjcDGk16CCEFVExoIPNXUAfRP1h2ByAZQ3h4QAFMjjieBRG1MSJzbEn1BDwDRDCENNd6J+GE1nIonM4RoTejioI9aNzQWo0pIdFRtThjh9GRAWTzG24k4jp0ZhRjCOSMNGRTCbp0JI7WukTluKFoBGTE5EAZXNaQiQhkyn2hGBGSjC54ENkMmkmRC6sGSdPcxpop0R57rjnQ31C6QJQhTJ36EVoSqTmmgO0+dCbO/45JX5iXtSof5ZCxCWQEVHJZKc9jerlRaMiuOqX6ZQOgCpDT0IpJU8wOjqrRTp62KOTNo7460OtOvgqWKY6WOJEmLKoaUMr7uhiWc2m9+xDvbI4LIcsgmjWEcEOcMGyFR14ooIWVYvftWO5R6Z8t05kn7DeUgQmfvWu1d134fJ4p0Xn4bfeZFTMEO4FM8Rb4RAzXDfDEAo7RsUOKpAgHAkq7BAxbxx37PHHIIcs8sgkl2zyySinrPLKLLfs8sswxyzzzDTXbPPNOOes88489+zzz0AHLfTQRBdt9NFIJ6300kw37fTTUEct9dRUV2311VhnrfXWXHft9ddghy322GSXbfbZZgcEACH5BAkEAGAALAAAAADIAMgAhwAAAAdEZwJwrwBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQRzsgl1swx3tA54tA94tBB5tRF6tRN7thZ8txl+uByAuR+BuSGDuiWFuy6KvjWOwDqRwj+UxEKVxEaXxkqax0+dyVOfyliiy1+mzmap0Gmr0W6u0nGw03ez1X2214G42Ie82o/A3ZvH4Z3I4aLK4qXM46vQ5bXV6LvZ6r7a6r7a6r/b68Db68Hc7Mbf7crh7tDk8NTn8dnp89zr9N3s9N7s9N/t9eLu9ubx9+rz+O30+e71+e71+e/2+vD2+vL3+/f6/Pv9/f7+/v7+/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+AMEIHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3r2YCI7fOIyMfGLEyBPMT2IMWM58eYzjHHm48NDcg4selGk03868hsYkKrj+N1eR5C1x4x2thBfPXYWVizyos2fugcdaKzXkL/dQ433G9fNtp4JFPATInX1oEVECeyUQgZF2BnJHA0VJ6BfhAB6UZxYRETpY0RMXigddRACGOMCARFnhX3oLGljCihIpZ2JzMUhU4IzMIQiUgss12BGEEU5IEY7bSeQCkcu5EBSH23mokYUBekARk0gO4KRDUJooJVBZlrARiCaOCBEOVS6HA0RgVgnjTlawt2ZFVF545UNklnnmQ3ESOadObYr35pQz7tlQnVXe6VCeOAqaEwnckfDljGLSWeYAhjaUJpKR7oSoohRlyd6WEiEaaESeXgjqT0QwOgAJnFIEpIHcQk5U5qkOHYmkkkOp+JEVqgZIwp8OyUhkjRHdSOQPG3Zo0aWQTlRiiChu2Ot2rD5IZKwRVThjhmlZQYOFHtAArETPGhjtRMZeqKNaTxBBRKYXqReiC+M6FF+E9UX2KnvYWgRegORNlhx7z3UkHbgurEuZb8C1mlG77/Im8cQUV2zxxRhnrPHGHHfs8ccghyzyyCSXbPLJKKes8sost+zyyzDHLPPMNNds880456zzzjz37PPPQAct9NBEF2300UgnrfTSTDft9NNQRy311FRXbfXVWGet9dZcdx10QAAh+QQJBABoACwAAAAAyADIAIcAAAAAcLAAcLAAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbECcrEGdLIJdrMLd7QNd7QNeLQPebUQebUSerUTe7YWfLcZfrgdgbkhg7olhbsohrwqiL0sib4tib4vir4wi78yjL80jcA4kME8ksI+k8NBlMRElsVMm8hZosxlqc9wr9N4s9Z+tteBuNiDudmGu9qKvduNv9yPwNyRwd2Vw96ZxuCdyOGfyeKky+OpzuSv0ua11ei62Om/2+vC3OzG3+3J4e7M4u/N4+/O4+/O4+/Q5PDS5vHV5/HY6fLa6vPc6/Te7PTe7PTf7fXg7vXi7vXk8Pbn8ffp8vjr9Pjt9fnu9fnv9vry9/v0+Pv2+vz5+/36/P39/f7+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gDRCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz694tm4oOGixY0NBB5bJvFhkGDMjAgnjHIB+US5f+IcjkLjSmax9Ao0vGLiy2/m9n4f0xExPitZsobvF8+u0mmLRl4sOHfI5Mkr+fnoH9xC7o7adeeWjNsB0NGgEo4IAUrbDgeGi5J158GMXwoHYzTBTEhdsRcVaA6ZlwERUcauffQ9GVSB1RRHj4kYECZlhRDipKl0NEJNYo3Yk9+aBfBj54dKFFDuq4QkQ06qjcjUBhwF9HTFx430RO6phBRDAqKaNPRHTIkQ8XBkmRkspFVKSSR/7UpXYuagTmg2JOROYAZs6Z5k9VKocBlFJWROaeEGWp45Y++VAlBnFuNGRFZ6p4p0NJKslkUC2CJGh6hEoUqYqTOpSjkjyGBeKEI4IqUYo1fnCWhPARWNGlvA9m6tCGOrZpFqyyUqQghya4ClGjFz4aYX1TasREngJiEOpDu17Yq2OsvrfeRdHuR+FjXcA63Qy+6gqseCt02xgVOaxw6Ao5LGsREahq94GtupE7wworzJAub/jmq+++/Pbr778AByzwwAQXbPDBCCes8MIMN+zwwxBHLPHEFFds8cUYZ6zxxhx37PHHIIcs8sgkl2zyySinrPLKLLfs8sswxyzzzDTXbPPNOOes88489+zzz0AHLfTQJQcEACH5BAkEAGcALAAAAADIAMgAhwAAAABwsABwsABxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQFxsQVzsgh1swx3tA14tA14tA14tA54tBB5tRB5tRF6tRN7thR8thh+txt/uB+BuSKDuiWFvCyJvjCLvzWOwDqRwj2Tw0CUxEOWxUaYxkybyFGeyVSgylmizFykzV6lzWGnzmWpz2ir0Gqs0XCv03ay1Xu114S62Ym9242/3I/A3ZHB3ZXD35rG4KDK4qjO5KzQ5rDS57LT57TV6LrY6b3a6r/b67/b67/b67/b68Db68Ld7MXe7cjg7czi78/k8NHl8NTm8dfo8trq89zr9N7s9ODt9eHu9ePv9ubx9+ny+Ov0+Oz0+e71+e/2+vD2+u/2+vD3+vH3+vT4+/b6/Pz9/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+AM8IHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3h2bSo4UJQYMKJEiB5XMXJAg4fKRigvh0KMPcHF8MpESFqJbKEFk44/s0sP+W+gOmYuM8NFlML/IA737ATweN+nwHnqHJhZ/1HdPXi2RHDkg0REX9O0nXAfrSUQFeAZqV91Z32n3w0bnNSicDBS1YGF4LaClIXouZETEhtD19xAVJIb34Fj6vTfhRcGlWIJEOKQoHQ5DNYEfSAyiZwFGPVrYgUQp2BhdCkKFIFwIH424n4kScWHkAAk6FOOUMwLVRHQ7clTjfjhW5KSNUDI0ZXRBbQldlxt9WV+YFI2ZYpkLnQldkks2aSCdD0lpZJUNXWlklmmy2VGQ0v14EaIGDhlRkWciWVaL7r1okaAWEvqQm0bGZ9aHHIpIpoJ2rkhWhNBZYClGFVqI4USuoKbYoX844MBnRQQKCeiJjO5nwa6HzdeooRFRuuGthplXn3oYtbehp5BdV+CB3G1ERK/aIcsYF0QQASxGVMTKoam3UYEDcMIRhwO5vLXr7rvwxivvvPTWa++9+Oar77789uvvvwAHLPDABBds8MEIJ6zwwgw37PDDEEcs8cQUV2zxxRhnrPHGHHfs8ccghyzyyCSXbPLJKKes8sost+zyyzDHLPPMNNds8804TxwQACH5BAkEAGUALAAAAADIAMgAhwAAAARUgQBwsABxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQNzsgx3tA54tA94tA94tRF6tRV8thl+uB+BuSeGvC2KvjSNwDqRwj6Tw0GVxEaYxkybx0+dyVKeyVehy1ykzWKnzmeq0Gyt0nKw1Hmz1n+32IW72oq9247A3JDA3ZLC3pbE35rG4J3I4Z/J4qHK4qTM46bN5KrP5a3R5q7R5q/S57DT57LU57bW6brY6bzZ6r/b68Hc7MTe7Mjg7cvh7s7j79Dl8NPm8dbo8trq89zr9N3s9N7s9N7s9N/t9d/t9eHu9eTw9ubx9+jy9+rz+O31+fD2+vT5+/n7/fz9/v3+/v7+/v7+/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+AMsIHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3h17ygwTIwYMGGFixhTeU1QIX858gIrjlacAefECCPSNPzI03z4gQ5HJ2bf+Z/ihEQf38wNwQN5iAv0AE1su/nB//nvjLdrpZ4hPcUp++s1lcB1aReSQgxEetQfgexUpt+B2KqS1xAfMfbAEdg8KR55EU2TI3YBjLXHehRn9t2AGE83g4XYznEUhdx9k1OGKIDak4IrLmSDUFjPMwJ9HRbhnn0XzrbghRCLgyJwIQqk4QIsfmYeeehe9gOMLEinZXJPCQemRlOdRaZGVK2IZkZbM7djjjx0FiR6JROJ45ENJosmkWS9uFyNGM3pYI0M3KqmjWSJyB+dFJgKIokROailmWRNWeKh8Hs75UJ9K/jlWETjgMORGgbo36EQO4hghY/gpymZE/uG4n2OQ7Im6qkRFevhpY+EFaGlFYC74KGRT/EDdD5pWVESi3HmXW3LuPYfcb3WKUFyxvFVr7bXYZqvtttx26+234IYr7rjklmvuueimq+667Lbr7rvwxivvvPTWa++9+Oar77789uvvvwAHLPDABBds8MEIJ6zwwgw37PDDEEcs8cQUV2zxxRhnrPHGHHfs8ccg4xsQACH5BAkEAIkALAAAAADIAMgAhwAAAABQfQBwsABwsABwsABwsABwsABwsABwsABxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQFxsQRzsgZ0sgd0sgp2swx3tA14tBB5tRJ6thV8thh+txt/uB2AuR6BuR+BuSCCuiKDuiOEuyaGvCmHvSyJvi+KvjKMvzaOwTqRwj2Twz+Tw0CUxEGVxESWxUiZxkybx02cyE6cyE6cyE+dyVCdyVGeyVKeylWgylehy1mizFykzWCmzmSoz2qs0W+u0nSx1Hm01ny1136214G42IO52Ya72oq924y+3I7A3JHB3ZTD3pjF4KDK4qfN5K3Q5rHT57PU6LjX6bnY6bvZ6r3a6sDb68Pd7MXe7cjg7cvh7s3j787j78/k8NDk8NHl8NPm8dfo8trq893s9ODt9eTw9uny+Ov0+e71+e71+e71+e71+e71+e71+e71+e/2+u/2+u/2+u/2+u/2+u/2+u/2+u/2+u/2+vP4+/n7/f7+/v7+/v7+/v7+/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+ABMJHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3i2bjRQmNGgwkcKGt0AsKBIoX64cBRbdd2gwn76cxh3Kd7wwIUKEiZfrGsv+uKBOPoGLMpKxgKAO4jnGO+PLk3cBvvGdHvIT9KhPUXp+8jQ8xsN/+lmEBYHlebFWGUwwgV5HByLo3kTJIUgdCmndx9x+G92xHoIg8PcQGxaWV9xZA07Xw0ZelJiAghJF4SJ1UZzVInkPYrSEi0tMtOOMzPUoFA8rhvQjjRoR4SIRE/kHpHIBDsmDSEdOV2NGSpbIpEROPhllWWWUl+NFVRJ4ZURlziikWSkyN6VGN1oIY0QyPqncmWXd0WYCPIhokYcWhjgRiXYmcCJaZUQRxZgaRUjghBJVCCSGje1Z3psUOTrjnIvpmV+fF3Vp4ZeOqccepBXB5yJ9kmW3BHeBS3y3kXgWnndbdARap5sXkk6HAqe6sRHFEsEtEcWhxiWr7LLMNuvss9BGK+201FZr7bXYZqvtttx26+234IYr7rjklmvuueimq+667Lbr7rvwxivvvPTWa++9+Oar77789uvvvwAHLPDABBds8MEIJ6zwwgw37PDDEEcs8cQUaxYQACH5BAkEAF8ALAAAAADIAMgAhwAAAAhBYQBwsABxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQNysQh1swx3tA13tA95tRJ6tRR7thh9txt/uB6BuSOEuyuIvTSNwDqRwj2Swz+Tw0GVxESXxUmZx06cyFGeyVWgy12kzWmr0XKw1Hq01n6314K52Yi82o/A3ZfE353H4Z7I4Z7I4Z7I4Z7I4Z/J4p/J4qHK4qXM46nO5K3R5rDS57TU6LfW6brY6b3a6r/b68Db68Lc7MTe7Mff7cvi7s3j787j79Dk8NLm8dXn8tnp89vr893s9N/t9ePv9ufy9+rz+O31+e/2+vD2+vH3+vP4+/n7/fv9/fz9/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+AL8IHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3k07ChEiUXgXxIECw4DjAzCg0MF7CQnk0JGTWJIbh/Ho2DHgoGzFhwsSJFz++LCyEQf288i3Rx7SAXuHIRmXXEefnfpjF/QHuMA4Ij96Eo8N4d8A8FVk3oDnqZcWDi64wFxHVrTnXwfkUXQCguedoNYH0IHQkQ8Y+lDRfBgih8GC2CmYEX4I7jdRFCWeV2FQS9gXEovQuahRfwiOQJGAMUZXII02goQjcjpmxOOAPk4EZJDIDVnWgdCpiNGR+SUJEYxQIhccWhwi98GHIY7YZXJrMeiClRlFOCCFFV3YpYaNPUmflBJRGaSIjmEZHZsSLVlikwFKCN178ZE4IAZFOtadCyOMIN6MGOk5IKCwWbcoprEtISh2IzR6Gw4nkIjBCZziFsUQQ3wp3KthsMYq66y01mrrrbjmquuuvPbq66/ABivssMQWa+yxyCar7LLMNuvss9BGK+201FZr7bXYZqvtttx26+234IYr7rjklmvuueimq+667Lbr7rvwxivvvPTWa++9+Oarb2cBAQAh+QQJBABOACwAAAAAyADIAIcAAAAAcLAAcLAAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbECcrEFdLIHdbMKdrMQerYXfrgfgromhrwuir41jsA7ksJFl8VNm8hTn8pZosxdpM1fpc5gps5jqM9mqdBpq9FurtJ2stV7tdZ+tteBuNiEutmJvNuLvtuOv9ySwt6XxN+axuCeyOGfyeKhyuKkzOOozuSr0OWw0+e62OrD3ezK4e7Q5PDV5/Lb6vPe7PTh7vXj7/bm8ffs9Pnu9fnv9vrv9vrw9vr0+Pv4+/z5+/37/f39/f7+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gCdCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz697Nu7cTITVOjBhxooYQ3zw+DFjOfPkHHrthNJ/OHEZuE9SzDzBRecUHDBg+/rDgKF17duuRc1igbiFHRh7mzUN/nCO++4se4mv3AHm9eQsXCaGfecepBYMGGsTw0QoDrmBReQNSV4OBzaHHUX768VcRdhFSx11aGjSnIUf+xYeBRSN06KFaITI34kYYDHhiRSmq2NwIFFbnEYbxvSgRhzYu92FaMHjggYUcMaifgxXVECRzEzpWYnYAWiTgkwMU2Fh92klwn0U8qugjY+qx96VF8AU5X2QreACeB0xqBGGESM4GpH5D2jandnXaxkOYIq65G3AmDGeCcb4lquiijDbq6KOQRirppJRWaumlmGaq6aacdurpp6CGKuqopJZq6qmopqrqqqy26uqrMrDGKuustNZq66245qrrrrz26uuvwAYr7LDEFmvsscgmq+yyzDbr7LPQRivttNRW21BAACH5BAkEAFkALAAAAADIAMgAhwAAAAk3UAFwrwBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQFxsQVzsgp2sxF6thd9tyGDui6KvjSNwDuRwj2Twz+UxEKVxESWxUeYxkqax0ybyE6cyE6cyE+dyU+dyVCdyVGeyVWgyliiy1ujzGCmzmOoz2ir0Gyt0m+v03Kw1Hez1X6314O62Yq925DB3ZTD3prG4KHK4qXN46rP5a3R5rDS57HT57TV6LfW6bvY6rzZ6r7a6sDb68Pd7Mjg7c3j79bo8tvq89/t9eTw9ufx9+ny+O31+fD2+vH3+vP4+/T5+/X5/Pf6/Pr8/f39/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+ALMIHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3s27t++FQ2qswIBhRY0hvp2YGMC8OXMTTnbzqOC8+oAKPHLzsM59QHbKQ17+cODwAvlGJ9S7V68QPbKTF9ZftMdIQj13E5Lhc3+RcYj97kZA5p965llUw3/c1cDWECaYUGBH+nXH30UrIGjdCmzVNwAJIHFgHwcYYWBhdSCupSGHH3moXokWiThicyymNQQJJDzIUYT7YVThi8xh+NiA3dk40YE8DqAgZDg6N+FFQL4YIGTvxTffRRqOiKJk4Y1XHkfojcjebdtZ+B2Y6XWH3W5OVFkdCVPqZoRw4xn35G901mnnnXjmqeeefPbp55+ABirooIQWauihiCaq6KKMNuroo5BGKumklFZq6aWYZqrpppx26umnoIYq6qiklmrqqaimquqqrLbq6qsYsMYq66y01mrrrbjmquuuvPbq66/AFhYQACH5BAkEAEIALAAAAADIAMgAhwAAAAk6VgJwrgBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQJysQVzsgp2sw94tRJ6tRh+tyCCui6KvjaPwT2Sw0CUxESXxUqax1GeyVqjzGGnzmmr0W2u0nOx1Hiz1YC42Ii82pLC3prG4KDJ4qXM46vP5bHT57rY6sff7c7j79Pm8djp8t7s9OPv9ujy9+z0+e31+e71+fX5/Pn7/fr8/f39/v7+/v7+/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+AIUIHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3s27t+/fFFWM4DBgAIcRKnzjIF68efEPOHa7qOC8+oAKLnLjoG69eoXolGfxDD8+oyPz7tU/UFbBvXiF5BpVoEcPH/KM9s0rlM84Yn73EW7hAB5I/f2n0Xn+NceBUQOOhENxDZqH3oIZJdhdWw8OECFHCDpHIUYWWhfghhwVaB2AGXWY4IeP3WedfhqZGCKKkbHn3HsbyRdicfVFJh4H5EkYonq3bWfhd7lN5x92uy2HHnS+CcfccT0CZ+WVWGap5ZZcdunll2CGKeaYZJZp5plopqnmmmy26eabcMYp55x01mnnnXjmqeeefPbp55+ABirooIQWauihiCaq6KKMNuroo5BGKumklFZq6aWYZqrpppx26umnoIYqqqQBAQAh+QQJBABNACwAAAAAyADIAIcAAAAAbqwAcLAAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEBcbECcrEHdLIKdrQPebUUfLYXfrcdgbkjhLsph70yjL89ksNHmMZMm8hOnMhOnMhOnMhOnMhRnclVoMpcpMxjqM9urtJ5tNWKvtufyeGr0OWz1Oe31ui62Om92uq/2+vA2+vD3ezG3u3L4u7R5fDV5/La6vPf7fXk8Pbo8vjs9Pnv9vrw9vrw9vrv9vrv9vrw9vry9/ry+Pv0+fv2+vz5+/38/f7+/v7+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gCbCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz697Nu7fv3xd58AA+kMUIDAMGYBjBwjePEcmjRx8xXDePCtKzD6hQHfcH7dpH4liGcXw5jI4swINvPhmG9vMbv6vP/oGyfOn1NyKfLx3DURjwkQTgSPv1txEP/GnX3VADltRgSAVG559GCCYo3YKP3RddfhpFyN+EkrmXXYAZacgfhyF+gAEGH5CYUXoWDsDebSaCh6Jt1/G3AYY41pjcBzzixoKKybE4I3DCEafkkkw26eSTUEYp5ZRUVmnllVhmqeWWXHbp5ZdghinmmGSWaeaZaKap5ppstunmm3DGKeecdNZp55145qnnnnz26eefgAYq6KCEFmrooYgmquiijDbq6KOQRirppJRWaqltAQEAIfkECQQAQwAsAAAAAMgAyACHAAAAES4+Dm6kAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAnKxC3a0FXy3IIK6K4m+NI7APJLDQJTEQpbFR5jGTJvIVJ/KXqXNZanPbK3SdrLVhbvZkcHdoMrhrNHludfpvNnqvtrqwNvrw93sx9/ty+HuzuPv0OTw1Obx2enz3ez04u725fD36PL36/P47fX57/b67/b67/b68ff68vj79Pj79fn89vr89/r8+Pv9/f3+/v7+/v7+/v7+////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CP4AhwgcSLCgwYMIEypcyLChw4cQI0qcSLGixYsYM2rcyLGjx48gQ4ocSbKkyZMoU6pcybKly5cwY8qcSbOmzZs4c+rcybOnz59AgwodSrSo0aNIkypdyrSp06dQo0qdSrWq1atYs2rdyrWr169gw4odS7as2bNo06pdy7at27dw48qdS7eu3bt48+rdy7ev37+AAwseTLiw4cOIEytezLix48eQI0ueTLmy5cuYM2vezLmz58+gQ4seTbq06dOoU6tezbq169ewY8ueTbu27du4c+vezbu379/AP7JgEVzgiQsDkg+4cMJ3DQ/Kow/wUIM3dOnRPew+gR1788oskLsvf+GRQnfpFyyLT56+43nsSCNEMFmj+kj4HFm8l07cqHz69omE30b67adcf5Ott5xHBipn2QviXRDgRgqe1x5u3Bn4XW7Xnafdbs95OKFux0XHXHFDDIfiiiy26OKLMMYo44w01mjjjTjmqOOOPPbo449ABinkkEQWaeSRSCap5JJMNunkk1BGKeWUVFZp5ZVYZqnlllx26eWXYIYp5phklmnmmWimqeaabLbp5ptwxinnnHTWaeedSQYEACH5BAkEAD0ALAAAAADIAMgAhwAAABooLzdriAx3tAZ0sgRzsgFxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQJysQl1sxJ7thp/uCWFvDSNwEGVxEqax1SfylqjzF+mzmWpz2us0XOx1IK52JbE3qLL4qvQ5bTV573a6sXe7cjg7svh7s3i787j79Dk8NTn8dnp89vr897s9OLu9ubx9+v0+fH3+vH3+vT4+/b6/Pn7/fz9/v7+/v7+/v7+/v7+/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+AHsIHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3s27t+/fwIObRIFCeA8WFw4oP3CBxe8PEZYvjwCiN4vo0qc7xwwDRsjk2aW8X0CKIkOG4ks5KOcAMnx4pBmUZ1gKQ7r3jijcZ0dfNP6B+UrVt9x9HOWn33L8EVXeeUypdwB7Hx24XGbdfSfheLuxMIB+A2y32wcbZjeACL8hJ56HwBFn3IostujiizDGKOOMNNZo44045qjjjjz26OOPQAYp5JBEFmnkkUgmqeSSTDbp5JNQRinllFRWaeWVWGap5ZZcdunll2CGKeaYZJZp5plopqnmmmy26eabcMYp55x01mnnnXhmFhAAIfkECQQAOQAsAAAAAMgAyACHAAAADxUZAHGxAHGxAHGxAHGxAXGxA3KxB3WzDni1Fn23H4K6J4a8NY7BT5zJZanQdLHUerTWfbbXf7fYgrnYhLrZhrvajL7blcPensjhpMzjq9DlsNLntNXouNfpu9jqvNnqv9vrwNvrwdzsw93syODuzuPw1efy2erz3ev03uz04O314u724+/25fD35/L38/j79vr8+fv9+/z9/f3+/v7+/v7+/v7+/v7+////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CP4AcwgcSLCgwYMIEypcyLChw4cQI0qcSLGixYsYM2rcyLGjx48gQ4ocSbKkyZMoU6pcybKly5cwY8qcSbOmzZs4c+rcybOnz59AgwodSrSo0aNIkypdyrSp06dQo0qdSrWq1atYs2rdyrWr169gw4odS7as2bNo06pdy7at27dw48qdS7eu3bt48+rdy7ev37+AAwseTLiw4cOIEytezLix48eQI0ueTLmy5cuYM2vezLmz58+gQ4seTbq06dOoU6tezbq169ewY8ueTbu27du4c+vezbu379/AgwtnuWLF8BwTEggQkGBC8AbLowtooDTEhAkh4k6QLt350RDSs6wv5cBBpHLuyxMg3R7de1IOy8t/XIFeunGj7Je7RwpfgHyP9NW33H1FgRedeEqRZ56A6iFlHXbaCbjfbtBxRx1wyaU34W/FHefhhyCGKOKIJJZo4okopqjiiiy26OKLMMYo44w01mjjjTjmqOOOPPbo449ABinkkEQWaeSRSCap5JJMNunkk1BGKeWUVFZp5ZVYZqnlllx26eWXYIYp5phklmnmmWimqeaaawYEACH5BAkEAGEALAAAAADIAMgAhwAAABAQEDJfeABxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQBxsQFxsQNysQVzsgh1sw94tRN7thyAuSqIvTiQwUeYxk+cyVWgylqizF2kzWCmzmWoz2qs0XCv03q01n+32IO52Ye72oq924y+3I6/3I6/3I/A3I/A3Y/A3Y/A3ZDB3ZHB3ZLB3ZLC3pPC3pTD3pbE35fE35rG4KDJ4aTM46jO5KvP5bHT57bW6LnX6bvZ6r3a6r7a6r/b67/b68Db68Hc68Lc7MTe7Mff7cng7svh7s3j79Tn8drq893s9OHu9eXw9ufx9+jy9+rz+Ov0+Oz0+e71+fD2+vf6/Pf7/P7+/v7+/v7+/v7+/v7+/v7+/v7+/v7+/v7+/v7+/v///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wj+AMMIHEiwoMGDCBMqXMiwocOHECNKnEixosWLGDNq3Mixo8ePIEOKHEmypMmTKFOqXMmypcuXMGPKnEmzps2bOHPq3Mmzp8+fQIMKHUq0qNGjSJMqXcq0qdOnUKNKnUq1qtWrWLNq3cq1q9evYMOKHUu2rNmzaNOqXcu2rdu3cOPKnUu3rt27ePPq3cu3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sy5s+fPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3s27t+/fwIMLHx7zR5CmSFiwQDI3hYQBAySwUMoBOnQOcVNYt54CKZLt0Jmtv30OXgJS7eC7i6RCxWSIECJ/gLf+4yj67epDsncPP6T8+QPUZ9R34InnFnnbmYdUddZhB9d93CmFRAopGPggeRLkF9wPAhLn4YcghijiiCSWaOKJKKao4oostujiizDGKOOMNNZo44045qjjjjz26OOPQAYp5JBEFmnkkUgmqeSSTDbp5JNQRinllFRWaeWVWGap5ZZcdunll2CGKeaYZJZp5plopqnmmmx6GBAAIfkECQQAQQAsAAAAAMgAyACHAAAAGx0eYGNlA3KxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxA3OyCna0G4C5MIy/RpjGW6PMaqzRcK/Td7PVfLXXf7fYhbrZi77blMPem8fgoMnipMzjq9DlsNPntdXovNnqwNvrw93syODuzePv0uXx2Onz2+vz3ez03+313+313+314O314e714u/25PD25vH36fL46vP47fX57vX58Pb68vf78/j79Pn79vr89/r8+Pv8+fv9+vz9/P3+/f7+////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CP4AgwgcSLCgwYMIEypcyLChw4cQI0qcSLGixYsYM2rcyLGjx48gQ4ocSbKkyZMoU6pcybKly5cwY8qcSbOmzZs4c+rcybOnz59AgwodSrSo0aNIkypdyrSp06dQo0qdSrWq1atYs2rdyrWr169gw4odS7as2bNo06pdy7at27dw48qdS7eu3bt48+rdy7ev37+AAwseTLiw4cOIEytezLix48eQI0ueTLmy5cuYM2vezLmz58+gQ4seTbq06dOoU6tezbq169ewY8ueTbu27du4c+vezbu379/Agwvfq+LDBxXCbVAgwJwABRtyVYgQgTzp8ubMKcS9gP0CUhXYsa1Xbws+/HiiH8I3/yCSgvaSNqCLFKFexNH06gmwD+neZPyR9IVnn1HlqXfeWgU2d+BQ12H33lvcNZdBUso5OJd01DFV3HHDdejhhyCGKOKIJJZo4okopqjiiiy26OKLMMYo44w01mjjjTjmqOOOPPbo449ABinkkEQWaeSRSCap5JJMNunkk1BGKeWUVFZp5ZVYZqnlllx26eWXYIYp5phklmnmmWimqeaabO4VEAAh+QQJBABdACwAAAAAyADIAIcAAAAQEBBDW2kCcrEAcbEAcbEAcbEAcbEAcbEAcbEAcbECcrEEc7IJdrMbgLkmhrwxjL86kcJHmMZOnMhSnslYostcpM1jqM9qq9Fxr9N1sdR6tNZ+tteGu9qPwN2Vw96ZxuCeyOGkzOOpzuSt0eax0+e31um62Om82eq/2+vC3ezG3+3K4e7N4+/Q5PDU5/HW6PLY6fPa6vPb6/Td6/Tk8Pbn8ffo8vjq8/js9Pnt9fnv9vrx9/rz+Pv0+fvz+Pvz+Pvz+Pvy+Pvy+Pvx9/rx9/rw9vrw9vrv9vrv9vrv9vrv9vrv9vrv9vrv9vrv9vrv9vrx9/r1+fz6/P38/f79/f7+/v7+/v7+/v7+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gC7CBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz697Nu7fv38CD192RIsUO4TsoEFhOgMJx3zsaMGfe4DnvCdOnU4hLgwMHGkh3vWTPbr3jjhAhyh+lMR280RTjp6cAGWJ5iKUcpnM4Cj/+8vkf1UfAfUrlx5wHR4nnHwHqbXReekuxt1wD7hmFXXwTcOddhUZFN151v+1w4XITNMgbccYJp+KKLLbo4oswxijjjDTWaOONOOao44489ujjj0AGKeSQRBZp5JFIJqnkkkw26eSTUEYp5ZRUVmnllVhmqeWWXHbp5ZdghinmmGSWaeaZaKap5ppstunmm3DGKeecdNZp55145klQQAAh+QQJBAA7ACwAAAAAyADIAIcAAAAQEBA5XHABcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEEc7IJdrMUfLcggrovi79BlcRNm8hbo8xkqM9rrNFzsdR9tteFu9mQwd2gyeKozuSv0ua01ei72erA3OvG3+3J4O7M4u/P5PDT5vHW6PLc6/Te7PTg7fXi7/bk8Pbo8vfq8/jz+Pvz+Pv2+vz4+/z5/P38/f7+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gB3CBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz697Nu7fv38DdshgxgkXwHScmEFhOYMKJ3x6YSyfgofeJ6dOf71aOnfmEkCyMwF9m0X16jI8WlltgGkODhvNGR5SXPsIjeebik2pYruGo/PnL1dfRfcvlh9R+BPRnFIHzwddRegSst1R77yHFXXkUgGdgZdfNp91u0XVXnW/JSUfBh7/FQJyDx7Xo4oswxijjjDTWaOONOOao44489ujjj0AGKeSQRBZp5JFIJqnkkkw26eSTUEYp5ZRUVmnllVhmqeWWXHbp5ZdghinmmGSWaeaZaKap5ppstunmm3DGKeecdNZp55145qnnnksFBAAh+QQJBABQACwAAAAAyADIAIcAAAAKM0oSapwAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbECcrEHdbMKdrMOeLQRerUVfLcbf7gegbkhg7olhbwrib0zjcA5kMJAlMRGmMZRncldpM1rrNF3s9WDudmLvtuSwt6bx+ChyuKozuSs0Oav0ue11ei72erC3ezH3+7M4u/R5fDX6PLc6/Td7PTf7fXg7vXj7/bn8ffq8/js9Pnu9fnu9fnu9fnu9fnu9fnu9fnw9vry9/v2+vz6/P3+/v7+/v7+/v7+/v7+/v7+/v7+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gChCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz697Nu7fv32ZtsGBhA7jAExYGKB9g4YRvIR+WSx/wQQjv6NOlf9h9Int25x+F0Fi/XMH7dAseZWhQrkFGZRvmsxfnmEG6hsos4k9nwVFI9vEhiWdSBx0clZ9+y/G3kX/TAQiSgCUReBR8CCo330b1LZeBZeUhWEF6GWbgXmXdIQieRxBehp152+0GHYsO6nZCh8pVcOJvwhFn3I489ujjj0AGKeSQRBZp5JFIJqnkkkw26eSTUEYp5ZRUVmnllVhmqeWWXHbp5ZdghinmmGSWaeaZaKap5ppstunmm3DGKeecdNZp55145qnnnnz26eefgAYq6KCEFmrooYh+GRAAIfkECQQAMgAsAAAAAMgAyACHAAAADCs9Cm+oAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxAHGxA3KxB3SzFHu2HoG5I4S7KYe9MIu/OJDBQJTET53JY6jPerTWhLrZjr/cl8Tfn8nhq8/ltdXovtrryODuzuPv0+bx1efy1+ny3Ov03+316/P47/b6+Pv8+/z9/v7+/v7+/v7+/v7+////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CP4AZQgcSLCgwYMIEypcyLChw4cQI0qcSLGixYsYM2rcyLGjx48gQ4ocSbKkyZMoU6pcybKly5cwY8qcSbOmzZs4c+rcybOnz59AgwodSrSo0aNIkypdyrSp06dQo0qdSrWq1atYs2rdyrWr169gw4odS7as2bNo06pdy7at27dw48qdS7eu3bt48+rdy7ev37+AAwseTLiw4cOIEytezLix48eQI0ueTLmy5cuYM2vezLmz58+gQ4seTbq06dOoU6tezbq169ewY8ueTbu27du4c+vezbu3b68kSPwmyMHCgOMDLHTwnQID8ucDMKTYnUICdOgSpud2fh06htwcus53X87xg/HkHyqfF//8+8YP19NPZt+d44TrFiaToH9duEbxI30gH0nBGbUff8/5lxGAIgloUoFGIficffhRth5/7mkEH3QDRhaehOS9d54FHUrGHX0Z3lYdfdlRd6J32vHWwYsYhDgchMPlqOOOPPbo449ABinkkEQWaeSRSCap5JJMNunkk1BGKeWUVFZp5ZVYZqnlllx26eWXYIYp5phklmnmmWimqeaabLbp5ptwxinnnHTWaeedeOap55589unnn4AGKuighBZqKFsBAQAh+QQJBABaACwAAAAAyADIAIcAAAAIQWIAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEDc7IMd7QSerYXfbcbf7gdgbkegbkfgroggroig7okhbsoh7wtib4wi78yjMA1jsA4kME7kcI9k8NBlcRFl8VImcZLmsdMm8hUn8pepc1oqtB1sdSAuNiJvNuNv9yRwd2Twt6XxN+bx+CdyOGgyeKjy+OnzeSs0OWw0+e01Oi51+m+2uvD3ezI4O3K4e7M4u/O4+/P5PDQ5fDS5fHU5/HW6PLY6fPa6vPc6/Td7PTe7PTf7fXh7vXi7/bk8Pbm8ffo8vjq8/jr8/js9Pnu9fnv9vrz+Pv1+fz4+/z4+/35/P37/P37/f38/f7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gC1CBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz697NuzfVJ098F0zRQYIAARI6pPC948Lx588v7NjtArr15y5y77jOXcD02867+Vu/0LFGCAkSQnyXnEI89+Uaq1vPLrmD++sdNNbovv5xhPvWSaBRCN2FIFIRRbT1BIDXBYfRf9wJCFIRxyW41oIMQufgRRBeF0FIFApg4VodMvhhRgRyZyCII65lX4YCrIjRftz151h7MMKXkXzQ0SdZeACSx9EOIUQQgXqVbcegjbTxKJ6PuDXXnXS+EQdhBMoJRxBwWnbp5ZdghinmmGSWaeaZaKap5ppstunmm3DGKeecdNZp55145qnnnnz26eefgAYq6KCEFmrooYgmquiijDbq6KOQRirppJRWaumlmGaq6aacdurpp6CGKuqopJZq6qmopkpbQAAh+QQJBABFACwAAAAAyADIAIcAAAAJO1cAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEAcbEBcbEEc7IHdbMLd7QOeLQRerUXfbcdgbkhg7olhbsoh7wtib4xjL81jsA5kMI8ksM+k8NAlMRJmcdfpc1urdJ7tdaFutmLvtuVw96bx+Ciy+OpzuWt0eax0+e41+nE3u3Q5PDV5/Lk8Pbo8vfq8/jt9fnv9vry9/v2+fz4+/z4+/z4+/z5+/35/P35/P3+/v7+/v7+/v7+/v7+/v7+/v7+/v7///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8I/gCLCBxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhTqlzJsqXLlzBjypxJs6bNmzhz6tzJs6fPn0CDCh1KtKjRo0iTKl3KtKnTp1CjSp1KtarVq1izat3KtavXr2DDih1LtqzZs2jTql3Ltq3bt3Djyp1Lt67du3jz6t3Lt6/fv4ADCx5MuLDhw4gTK17MuLHjx5AjS55MubLly5gza97MubPnz6BDix5NurTp06hTq17NurXr17Bjy55Nu7bt27hz697Nu3dUFiVAUKAAogQL3y82CFjOfPmGF7tJNJ/O/ERu6dSzm7j9Irt3CtA3/qYQTjwFZeXes2/QWAMEdRA1IrNIn/44RvfZQUTGTp86CYwp0GfeY/j1N51+FxWYH0gpXHCBfWpNYCB1F2AkYXoUgHSBc2xdOCFzFV7kYXYTaMjhWgp+iKBFKR7IoIMQpsXfhwL8d1GA6Q3o2Hw0LhdjRS0ut+Jj6H24XkbtvRdfZN3RGJ5G400wAQg6SmbCh9vhdiV9E2SZW3LePecbCySAICUIJPzo25pstunmm3DGKeecdNZp55145qnnnnz26eefgAYq6KCEFmrooYgmquiijDbq6KOQRirppJRWaumlmGaq6aacdurpp6CGKuqopJZq6qmopqrqqqy26uqrDrDGKuustNZq66248hQQADsAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA" alt="Loading image">
                         </div>
                     `)
                 }
             }
         })

         /*
          * Jika setelah request API dan response 200 OK.
          */
         .done(function(e) {

             /*
              * Menambahkan variabel data yang bernailai output response API.
              */
             let data = e

             /*
              * Menambahkan variabel links yang bernilai data pagination dari response API.
              */
             let links = data.links

             /*
              * Jika tidak memiliki data
              */
             if (data.data.length == 0) {
                 /*
                  * Mengambil nilai jumlah kolum pada table
                  */
                 let lengthColumn = $(`table#${ element } thead tr th`).length

                 /*
                  * Menampilkan pesan kalau data kosong atau tidak ada.
                  */
                 $(`table#${ element } tbody`).html(`
                     <tr>
                         <!-- <td colspan="${ lengthColumn}" align="center">No matching records found.</td> -->
                         <td colspan="${ lengthColumn}" align="center">
                            <div class="py-4 text-center">
                                <div>
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:72px;height:72px">
                                    </lord-icon>
                                </div>

                                <div class="mt-4">
                                    <h5>Sorry! No Result Found</h5>
                                </div>
                            </div>
                         </td>
                     </tr>
                 `)

             /*
              * Jika data tidak kosong atau ada.
              */
             }else {

                 /*
                  * Menambahkan variabel baru bernama td
                  */
                 let td = ``

                 /*
                  * Menambahkan variabel baru bernama tr
                  */
                 let tr = ``

                 /*
                  * Mengambil nilai data dari response API dan dijadikan ke perulangan.
                  */
                 $.each(data.data, function (index, value) {

                     /*
                      * Mendefinisikan bahwa variabel td kembali ke semula atau kosong.
                      */
                     td = ``

                     /*
                      * Mengambil nilai kolom pada tabel dan dijadikan ke perulangan.
                      */
                     $.each(options.columns, function (indexColumns, valueColumns) {

                         /*
                          * Jika parameter html digunakan.
                          */
                         if (valueColumns.html) {
                             td += `<td style="vertical-align: middle;" key="${ indexColumns }">${ valueColumns.html(value) }</td>`

                         /*
                          * Jika parameter html tidak digunakan.
                          */
                         }else {
                             td += `<td style="vertical-align: middle;" key="${ indexColumns }">${ eval(`value.` + valueColumns.data) }</td>`
                         }
                     })

                     /*
                      * Mengubah nilai variabel tr dengan element baru yang bernama tr dan berisi dari variabel td.
                      */
                     tr += `<tr key="${ index }">${ td }</tr>`
                 })

                 /*
                  * Menampilkan nilai tr ke dalam tabel.
                  */
                 $(`table#${ element } tbody`).html(tr)
             }

             /*
              * Menambahkan variabel baru dengan nama paginationItem.
              */
             let paginationItem = ``

             /*
              * Jika parameter pagination > type sama dengan default.
              */
             if (options.pagination.type == "default") {

                 /*
                  * Mengambil nilai dari variabel links dan menjadikan ke perulangan.
                  */
                 $.each(links, function (index, value) {

                     /*
                      * Mengubah nilai variabel paginationItem dengan element li dan memiliki isi dari key label.
                      */
                     paginationItem += `<li class="page-item default ${ value.active ? `active` : `` } ${ value.url == null ? `disabled` : `` }" data-disabled="${ value.url == null ? `true` : `` }" data-active="${ value.active ? `true` : `false` }" data-url="${ value.url }"><a class="page-link" href="javascript:;">${ value.label }</a></li>`
                 })

             /*
              * Jika parameter pagination > type sama dengan simple
              */
             }else if(options.pagination.type == "simple") {

                 /*
                  * Mengubah nilai paginationItem dengan html pagination.
                  */
                 paginationItem = `
                     <li class="page-item simple ${ data.current_page == 1 ? `disabled` : `` }" data-disabled="${ data.current_page == 1 ? `true` : `` }" data-url="${ data.first_page_url }"><a class="page-link" href="javascript:;"><i class="bi bi-rewind"></i></a></li>
                     <li class="page-item simple ${ data.current_page == 1 ? `disabled` : `` }" data-disabled="${ data.current_page == 1 ? `true` : `` }" data-url="${ data.prev_page_url }"><a class="page-link" href="javascript:;"><i class="bi bi-caret-left"></i></a></li>
                     <li class="page-item active"><a class="page-link" href="javascript:;">${ data.current_page }</a></li>
                     <li class="page-item simple ${ data.last_page == data.current_page ? `disabled` : `` }" data-disabled="${ data.last_page == data.current_page ? `true` : `` }" data-url="${ data.next_page_url }"><a class="page-link" href="javascript:;"><i class="bi bi-caret-right"></i></a></li>
                     <li class="page-item simple ${ data.last_page == data.current_page ? `disabled` : `` }" data-disabled="${ data.last_page == data.current_page ? `true` : `` }" data-url="${ data.last_page_url }"><a class="page-link" href="javascript:;"><i class="bi bi-fast-forward"></i></a></li>
                 `
             }

             /*
              * Menghapus element pagination.
              */
             $(`#${ element }-laravel-table_pagination`).remove()

             /*
              * Jika parameter pagination > show sama dengan true
              */
             if (options.pagination.show == true || options.pagination.show == "true") {

                 /*
                  * Menambahkan element pagination ke html.
                  */
                 $(`table#${ element }`).parent().parent().append(`
                     <div class="mt-2 d-flex justify-content-between laravel-table_pagination" id="${ element }-laravel-table_pagination">
                         <nav aria-label="laravel-table_pagination">
                             <ul class="pagination ${ options.pagination.customClass }">
                                 ${ paginationItem }
                             </ul>
                         </nav>
                         <div class="table-info">
                             Showing ${ data.from != null ? data.from : 0 } to ${ data.last_page } of ${ data.total } entries
                         </div>
                     </div>
                 `)
             }
         })

         /*
          * Request API fail atau gagal.
          */
         .fail(function(err) {

             /*
              * Menambahkan variabel baru dengan nama status dan memiliki nilai yang diambil dari response error status API.
              */
             let status = err.status

             /*
              * Menambahkan variabel baru dengan nama statusText dan memiliki nilai yang diambil dari response error text API.
              */
             let statusText = err.statusText

             /*
              * Mengambil nilai jumlah kolum pada table
             */
             let lengthColumn = $(`table#${ element } thead tr th`).length

             /*
              * Menampilkan response error API ke dalam tabel.
              */
             $(`table#${ element } tbody`).html(`
                 <tr>
                     <td align="center" colspan="${ lengthColumn }"><b>${ status } -</b> ${ statusText }.</td>
                 </tr>
             `)
         })

         /*
          * Setelah request api fail atau success.
          */
         .always(function() {

             /*
              * Jika parameter loading > show sama dengan true.
              */
             if (options.loading.show == true || options.loading.show == "true") {

                 /*
                  * Menghapus element html loading.
                  */
                 $(`#${ element }-laravel-table_responsive .laravel-table_loading`).remove()
             }
         })

         /*
          * Mengembalikan nilai this element.
          */
         return this
     },

     /*
      * Fungsi untuk memberikan aksi terhadap komponen - komponen tabel.
      */
     _Func: function() {

         /*
          * Menambahkan variabel baru dengan nama element yang bernilai id element
          */
         let element = this[0].id

         /*
          * Menambahkan variabel baru dengan nama options yang bernilai dari variabel globalOptions
          */
         let options = globalOptions[element]

         /*
          * Menambahkan variabel baru dengan nama elementObject yang bernailai this element
          */
         let elementObject = this

         /*
          * Membuat fungsi change atau pilih limit data yang akan ditampilkan.
          */
         $(document).on(`change`, `#${ element }-laravel-table_filter .laravel-table_limit`, function() {

             /*
              * Melakukan pemanggilan fungsi _API dengan mengirimkan parameter baru.
              */
             $(elementObject)._API({
                 data: {
                     limit: $(this).val()
                 }
             })
         })

         /*
          * Membuat fungsi submit pada form input search.
          */
         $(document).on(`submit`, `#${ element }-laravel-table_filter form.laravel-table_search`, function(e) {

             /*
              * Mematikan fungsi refresh ketika submit form.
              */
             e.preventDefault()

             /*
              * Membuat variabel baru dengan nama search dengan nilai value dari form search.
              */
             let search = $(`#${ element }-laravel-table_filter form.laravel-table_search input`).val()

             /*
              * Melakukan pemanggilan fungsi _API dengan mengirimkan parameter baru.
              */
             $(elementObject)._API({
                 data: {
                     search: search
                 }
             })
         })

         /*
          * Membuat fungsi keyup atau input search kosong
          */
         $(document).on(`keyup`, `#${ element }-laravel-table_filter form.laravel-table_search input`, function() {

             /*
              * Jika value dari input search kosong
              */
             if ($(this).val() == "") {

                 /*
                  * Melakukan pemanggilan fungsi _API dengan mengirimkan parameter baru.
                  */
                 $(elementObject)._API({
                     data: {
                         search: ``
                     }
                 })
             }
         })

         /*
          * Membuat fungsi klik pada pagination default
          */
         $(document).on(`click`, `#${ element }-laravel-table_pagination .page-item.default`, function() {

             /*
              * Menambahkan variabel baru dengan nama url yang bernailai data-url dari element pagination.
              */
             let url = $(this).data(`url`)

             /*
              * Menambahkan variabel baru dengan nama active yang bernailai data-active dari element pagination.
              */
             let active = $(this).data('active')

             /*
              * Menambahkan variabel baru dengan nama disabled yang bernilai data-disabled dari element pagination.
              */
             let disabled = $(this).data('disabled')

             /*
              * Jika variabel active dan disabled bernilai false
              */
             if (active == false && disabled == false) {

                 /*
                  * Melakukan pemanggilan fungsi _API dengan mengirimkan parameter baru.
                  */
                 $(elementObject)._API({
                     url: url
                 })
             }
         })

         /*
          * Membuat fungsi klik pada pagination simple.
          */
         $(document).on(`click`, `#${ element }-laravel-table_pagination .page-item.simple`, function() {

             /*
              * Membuat variabel baru dengan nama url dengan nilai data-url dari element pagination.
              */
             let url = $(this).data(`url`)

             /*
              * Membuat variabel baru dengan nama disabled dengan nilai data-disabled dari element pagination.
              */
             let disabled = $(this).data('disabled')

             /*
              * Jika variabel disabled sama dengan false
              */
             if (disabled == false) {

                 /*
                  * Melakukan pemanggilan fungsi _API dengan mengirimkan parameter baru.
                  */
                 $(elementObject)._API({
                     url: url
                 })
             }
         })

         /*
          * Membuat fungsi klik pada kolom th sort data.
          */
         $(document).on(`click`, `table#${ element } thead tr th[data-sort][data-index]:not([colspan])`, function(e) {

             /*
              * Membuat variabel baru dengan nama columns dengan bernilai dari variabel options.columns.
              */
             let columns = options.columns

             /*
              * Membuat variabel baru dengan nama params dengan bernailai dari variabel options.data.
              */
             let params = options.data

             /*
              * Membuat variabel baru dengan nama sort dengan bernailai dari variabel columns.
              */
             let sort = columns[$(this).data(`index`)]['data']

             /*
              * Membuat variabel baru dengan nama sort_old dengan bernailai dari variabel params.sort atau kosong.
              */
             let sort_old = params.sort ? params.sort : ``

             /*
              * Membuat variabel baru dengan nama dir dengan bernilai dari variabel params.dir atau ASC.
              */
             let dir = params.dir ? params.dir : `ASC`

             /*
              * Jika variabel sort_old sama dengan variabel sort.
              */
             if (sort_old == sort) {

                 /*
                  * Mengubah nilai dir menjadi ASC atau DESC.
                  */
                 dir = dir == `DESC` ? `ASC` : `DESC`

             /*
              * Jika variabel sort_old tidak sama dengan variabel sort.
              */
             }else {

                 /*
                  * Mengubah nilai dir menjadi ASC.
                  */
                 dir = `ASC`
             }

             /*
              * Menghapus class bi-caret-up-fill dan mengganti dengan calass bi-caret-up pada eleemnt thead > th.
              */
             $(`table#${ element } thead tr th i.bi-caret-up-fill`).removeClass(`bi-caret-up-fill`).addClass(`bi-caret-up`)

             /*
              * Menghapus class bi-caret-down-fill dan mengganti dengan class bi-caret-down pada elemtn thead > th.
              */
             $(`table#${ element } thead tr th i.bi-caret-down-fill`).removeClass(`bi-caret-down-fill`).addClass(`bi-caret-down`)

             /*
              * Jika variabel dir sama dengan ASC.
              */
             if (dir == 'ASC') {

                 /*
                  * Menghapus class bi-caret-up dan mengganti dengan class bi-caret-up-fill pada element thead > th.
                  */
                 $(`table#${ element } thead tr th[data-index='${ $(this).data('index') }'] i.bi-caret-up`).removeClass(`bi-caret-up`).addClass(`bi-caret-up-fill`)

             /*
              * Jika veriabel dir tidak sama dengan ASC.
              */
             }else {

                 /*
                  * Menghapus class bi-caret-down dan mengganti dengan class bi-caret-down-fill pada element thead > th.
                  */
                 $(`table#${ element } thead tr th[data-index='${ $(this).data('index') }'] i.bi-caret-down`).removeClass(`bi-caret-down`).addClass(`bi-caret-down-fill`)
             }

             /*
              * Menambahkan key pada variabel options.data.
              */
             options.data = {
                 sort: sort,
                 dir: dir
             }

             /*
              * Melakukan pemanggilan fungsi _API dengan mengirimkan parameter baru.
              */
             $(elementObject)._API({
                 data: {
                     sort: sort,
                     dir: dir
                 }
             })
         })

         /*
          * Mengembalikan nilai this element.
          */
         return this
     },

     /*
      * Fungsi untuk refresh data atau request kembali ke API.
      * Dan memiliki parameter newOptions.
      * Parameter options yang memiliki nilai array.
      * {
      *      key1: `nilai`,
      *      key2: `nilai`,
      *      key3: `nilai`,
      *      key[n]...
      * }
      *
      * Penggunaan fungsi ini dengan cara berikut:
      * const table = $(element).laravelTable(parameter)
      *
      * table.fresh({
      *      key1: `nilai`,
      *      key2: `nilai`,
      *      key3: `nilai`,
      *      key[n]...
      * })
      */
     fresh: function(newOptions) {

         /*
          * Melakukan pemanggilan fungsi _API dengan mengirimkan parameter baru.
          */
         $(this)._API({
             data: newOptions ? newOptions : {}
         })
     }
 })
} ( jQuery ))
