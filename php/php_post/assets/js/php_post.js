const response_out_el = $("#response-output");
const response_raw_el = $("#response-raw");

// - Helper(s)
const error = message => {
  console.log(message);
};
const put_response = data => {
  response_out_el.html(data);
  response_raw_el.text(data);
}
// const put_response = data => {
//   // response.text(data);
//   console.log(data);
// }

// - Send Request
$('#send-request').click(e => {
  e.preventDefault();

  // Collecting Request Data
  const method = $('#method').val();
  const url = $('#url').val();
  const data = $('#data').val();
  let data_obj = {};

  if(data){
    let data_splits = data.split('&');
    for ( let split_unit of data_splits ){
      let kv_pair = split_unit.split('=');
      if(kv_pair.length != 2) error(`Invalid data Key-Value pair for value ${split_unit}`);
      else data_obj[kv_pair[0]] = kv_pair[1];
    }
  }

  if(Object.keys(data_obj).length > 0) $.ajax({
    url: url,
    method: method,
    data: data_obj,
    success: response => put_response(response),
    error: (jqXHR, exception) => error(`Error occured while fetching data! status-code:${jqXHR.status}, exception:${exception}`)
  });
  else $.ajax({
    url: url,
    method: method,
    success: response => put_response(response),
    error: (jqXHR, exception) => error(`Error occured while fetching data! status-code:${jqXHR.status}, exception:${exception}`)
  });
});

// - Clear Response
$('#clear-button').click(()=>{
  response_out_el.html('');
  response_raw_el.html('');
});