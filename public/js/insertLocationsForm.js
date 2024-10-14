document.querySelector("#numberOfLocations").addEventListener("change", (e) => {
    const totalNumberOfLocations = +document.querySelector(
        "input#numberOfLocations"
    ).value;

    const locationsFormContainer = document.getElementById(
        "locations-container"
    );

    locationsFormContainer.innerHTML = "";

    for (let i = 0; i < totalNumberOfLocations; i++) {
        locationsFormContainer.insertAdjacentHTML(
            "beforeend",
            `<div class="col-5 my-2">
              <p class="text-center mt-2 font-weight-bold">Địa điểm ${i + 1}</p>
              <div class="form-group">
                  <label for="longitude${i}">Kinh độ</label>
                  <input class="form-control" name="longitude${i}" id="longitude${i}" type="number" step="any" />
              </div>
              <div class="form-group">
                  <label for="latitude${i}">Vĩ dộ</label>
                  <input class="form-control" name="latitude${i}" id="latitude${i}" type="number" step="any" />
              </div>
              <div class="form-group">
                  <label for="startDate${i}">Ngày khởi hành</label>
                  <input class="form-control" name="startDate${i}" id="startDate${i}" type="date" />
              </div>
              <div class="form-group">
                  <label for="day${i}">Ngày thứ</label>
                  <input class="form-control" name="day${i}" id="day${i}" type="number" />
              </div>
              <div class="form-group">
                  <label for="description${i}">Mô tả</label>
                  <input class="form-control" name="description${i}" id="description${i}" type="text" />
              </div>
          </div>`
        );
    }
});
