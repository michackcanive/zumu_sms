
function getYear(year) {
    const years = ['2023', '2022', '2024', '2025'];

    years.forEach(function(y) {
      if (y === year) {
        $(`#${y}n`).removeClass('d-none');
      } else {
        $(`#${y}n`).addClass('d-none');
      }
    });
    console.log(Year, Date())
  }
