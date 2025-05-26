<?php include_once("dash.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shop Management</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .management-section {
            margin-bottom: 40px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .table-overflow {
            margin: 0;
            padding: 0;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
            text-align: center;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        tr input, tr textarea {
          background-color:rgba(255, 255, 255, 0);
          border: 0;
          border-bottom: 1px solid #2980b9;
          padding: 5px 10px;
          margin: 0px;
          width: 100%;
          font-size: 14px;
        }

        #cashiers_table td:nth-child(1), #inventory_table td:nth-child(1) {
          width: 20px;
          overflow: auto;
        }
        
        #cashiers_table td:nth-child(3), #inventory_table td:nth-child(7) {
          width: 100px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-edit {
            background-color: #2ecc71;
            color: white;
        }

        .btn-edit:hover {
            background-color: #27ae60;
        }

        .btn-edit:disabled {
            background-color:rgb(9, 105, 49);
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .btn-delete:disabled {
            background-color:rgb(137, 30, 18);
        }

        .section-title {
            color: #34495e;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ecf0f1;
        }

        #popup {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 5px;
            background: #2ecc71;
            color: white;
            display: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .add-button {
            margin-top: 15px;
            padding: 10px 20px;
        }

        img.product-icon {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="popup"></div>

        <!-- Cashier Management -->
        <div class="management-section">
            <h3 class="section-title">Cashier Management</h3>
            <div class="table-overflow">
              <table>
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Cashier Name</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody id="cashiers_table">
                      <?php include_once('../common/root.php');
                      include_once('../common/classes.php');
                      $stmt = $db_conn->prepare("SELECT name, job, id FROM staff WHERE job='cashier';");
                      $stmt->execute();
                      $staff = $stmt->fetchAll(PDO::FETCH_CLASS, 'Staff');
                      if (count($staff) > 0) {
                          foreach ($staff as $idx => $cashier) {
                              $id = htmlspecialchars($cashier->id);
                              $name = htmlspecialchars($cashier->name);
                              echo "<tr id='cashiers_table_$idx'>
                                      <td>$id</td>
                                      <td id='staff_$id'>$name</td>
                                      <td>
                                          <div class='action-buttons'>
                                              <button class='btn btn-edit' onclick='editCashierRow($idx)'>Edit</button>
                                              <button class='btn btn-delete' onclick='deleteCashierRow($idx)'>Delete</button>
                                          </div>
                                      </td>
                                    </tr>";
                          }
                      } ?>
                  </tbody>
              </table>
            </div>
            <button id="cashier_btn" class="btn btn-primary add-button" onclick="addCashier()">Add Cashier</button>
        </div>

        <!-- Inventory Management -->
        <div class="management-section">
            <h3 class="section-title">Inventory Management</h3>
            <div class="table-overflow">
              <table>
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Icon</th>
                          <th>Product Name</th>
                          <th>Description</th>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody id="inventory_table">
                      <?php
                      $stmt = $db_conn->prepare("SELECT id, name, description, price, available_quantity, last_updated FROM product;");
                      $stmt->execute();
                      $products = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
                      if (count($products)) {
                          foreach ($products as $idx => $item) {
                              $id = htmlspecialchars($item->id);
                              $name = htmlspecialchars($item->name);
                              $desc = htmlspecialchars($item->description);
                              $price = htmlspecialchars($item->price);
                              $qty = htmlspecialchars($item->available_quantity);
                              echo "<tr id='inventory_table_$idx'>
                                      <td>$id</td>
                                      <td><img src='product1.jpg' alt='Product' class='product-icon'></td>
                                      <td>$name</td>
                                      <td>$desc</td>
                                      <td>N$price</td>
                                      <td>$qty</td>
                                      <td>
                                          <div class='action-buttons'>
                                              <button class='btn btn-edit' onclick='editInventoryRow($idx)'>Edit</button>
                                              <button class='btn btn-delete' onclick='deleteInventoryRow($idx)'>Delete</button>
                                          </div>
                                      </td>
                                    </tr>";
                          }
                      } ?>
                  </tbody>
              </table>
            </div>
            <button id="inventory_btn" class="btn btn-primary add-button" onclick="addInventoryItem()">Add Item</button>
        </div>
    </div>

    <script>
      function randomPassword() {
        const bank =
          "abcdefghijklmniopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_+.";
        var used = [];
        var password = [];
        for (var i = 0; i < 8; i++) {
          const idx = Math.floor(Math.random() * 66);
          if (used[idx] === true) {
            i--;
            continue;
          }
          password[i] = bank[idx];
          used[idx] = true;
        }
        return password.join("");
      }

      function popup(text) {
        let popup = document.getElementById("popup");
        popup.innerHTML = text;
        popup.style.display = "block";
        // setTimeout(() => {
        //   popup.style.display = "none";
        // }, 2000);
      }


      var cashier_names = [];



      function addItemRow(
        table,
        n_cells,
        save_item_callback,
        save_item_text,
        item_btn,
        edit_action_page,
        edit_item_callback,
        delete_action
      ) {
        let new_row = table.insertRow();
        new_row.id = `${table.id}_${table.children.length}`;

        while (n_cells) {
          new_row.insertCell();
          n_cells--;
        }

        const action_row = document.createElement("div");
        new_row.insertCell().appendChild(action_row);
        action_row.classList.add("action-buttons");

        function process_btn(text, click_callback) {
          const btn = document.createElement("button");
          btn.innerHTML = text;
          btn.disabled = true;
          btn.id = `${text}_${new_row.id}`;
          btn.onclick = click_callback;
          btn.classList.add("btn")
          return btn;
        }

        const edit_action_btn = process_btn("Edit", () => {
          editRow(new_row.id, edit_action_page, edit_item_callback);
        });
        edit_action_btn.classList.add("btn-edit");
        action_row.appendChild(edit_action_btn);
        
        const delete_action_btn = process_btn("Delete", () => {
          deleteRow(new_row.id, delete_action, null);
        });
        delete_action_btn.classList.add("btn-delete");
        action_row.appendChild(delete_action_btn);

        item_btn.onclick = save_item_callback;
        item_btn.innerHTML = save_item_text;
        return new_row;
      }

      function updateDB(form_action_page, form_data, success_callback) {
        fetch(form_action_page, {
          method: "POST",
          body: form_data,
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Could not update database");
            } else {
              return response.text();
            }
          })
          .then((data) => {
            popup(`Success: ${data}`);
            const php_response_json = JSON.parse(data);
            if (php_response_json.successful) {
              if (success_callback) success_callback(php_response_json);
            } else {
              throw new Error(php_response_json.msg);
            }
          })
          .catch((err) => {
            popup(`Err: ${err}`);
          });
      }

      function editRow(row_id, form_action_page, callback) {
        const row = document.getElementById(row_id);
        callback(row);
      }

      function deleteRow(row_id, form_action_page, callback) {
        const row = document.getElementById(row_id);
        const form_data = new FormData();
        form_data.append("id", row.children[0].innerHTML);
        updateDB(form_action_page, form_data, () => {
          if (callback) callback(row);
          row.remove();
        });
      }

      function isUnchanged(value, old_value) {
        return value === null || value.length < 3 || value === old_value;
      }

      function isZero(value, old_value) {
        return value === null || value.length === 0 || value === old_value;
      }

      function removeRow(row, btn_toggle_callback) {
        row.remove();
        // btnToggleFn(btn, btn_text, callback)();
        btn_toggle_callback();
      }

      function btnToggleFn(btn, btn_text, btn_callback) {
        return () => {
          btn.onclick = btn_callback;
          btn.innerHTML = btn_text;
        };
      }

      function addCashier() {
        const cashier_name_input = document.createElement("input");
        cashier_name_input.type = "text";

        let row;
        let cells;

        row = addItemRow(
          document.getElementById("cashiers_table"),
          2,
          () => {
            const name_unchanged = isUnchanged(cashier_name_input.value);

            const toggle_cashier_btn_callback = btnToggleFn(
              document.getElementById("cashier_btn"),
              "Add Cashier",
              addCashier
            );

            if (!name_unchanged) {
              console.log("All good.");

              const cashier_data = new FormData();
              const random_password = randomPassword();
              cashier_data.append("name", cashier_name_input.value);
              cashier_data.append("password", random_password);

              updateDB("../cashier/register_cashier.php", cashier_data, (php_response) => {
                toggle_cashier_btn_callback();

                cells[0].innerHTML = php_response.id;
                cells[1].innerHTML = cashier_name_input.value;
                
                const action_btn = cells[cells.length - 1].children[0].children;
                action_btn[0].disabled = false;
                action_btn[1].disabled = false;

                cashier_name_input.remove();
              });
            } else {
              removeRow(row, toggle_cashier_btn_callback);
            }
          },
          "Register Cashier",
          document.getElementById("cashier_btn"),
          "../cashier/update_cashier.php",
          editCashier,
          "../cashier/delete_cashier.php"
        );

        cells = row.children;

        cells[1].appendChild(cashier_name_input);
      }

      function editCashier(row) {
        let cells = row.children;

        const id = cells[0].innerHTML;
        const name = cells[1].innerHTML;

        const cashier_name_input = document.createElement("input");
        cashier_name_input.type = "text";
        cashier_name_input.value = name;


        cells[1].innerHTML = "";

        cells[1].appendChild(cashier_name_input);

        const action_btn = cells[cells.length - 1].children[0].children;
        action_btn[0].innerHTML = "Done";
        const edit_callback = action_btn[0].onclick;
        action_btn[0].onclick = () => {
          const name_unchanged = isUnchanged(cashier_name_input.value, name);

          if (name_unchanged) cashier_name_input.value = name;

          if (!name_unchanged) {
            const cashier_data = new FormData();
            cashier_data.append("new_name", cashier_name_input.value);
            cashier_data.append("old_name", name);
            cashier_data.append("id", id);

            updateDB("../cashier/update_cashier.php", cashier_data, null);
          }

          cells[1].innerHTML = cashier_name_input.value;

          action_btn[0].innerHTML = "Edit";
          action_btn[0].onclick = edit_callback;
          action_btn[1].disabled = false;

          cashier_name_input.remove();
        };
        action_btn[1].disabled = true;
      }

      function editCashierRow(idx) {
        editRow(`cashiers_table_${idx}`, "../cashier/update_cashier.php", editCashier);
      }
      function deleteCashierRow(idx) {
        deleteRow(`cashiers_table_${idx}`, "../cashier/delete_cashier.php", null);
      }

      function addInventoryItem() {
        const product_name_input = document.createElement("input");
        product_name_input.type = "text";
        const product_desc_input = document.createElement("textarea");
        const product_price_input = document.createElement("input");
        product_price_input.type = "number";
        const product_aqty_input = document.createElement("input");
        product_aqty_input.type = "number";

        let row;
        let cells;

        row = addItemRow(
          document.getElementById("inventory_table"),
          6,
          () => {
            const name_unchanged = isUnchanged(product_name_input.value);
            const desc_unchanged = isUnchanged(product_desc_input.value);
            const price_unchanged = isZero(product_price_input.value);
            const qty_unchanged = isZero(product_aqty_input.value);

            const toggle_inventory_btn_callback = btnToggleFn(
              document.getElementById("inventory_btn"),
              "Add Item To Inventory",
              addInventoryItem
            );

            if (
              name_unchanged &&
              desc_unchanged &&
              price_unchanged &&
              qty_unchanged
            ) {
              removeRow(row, toggle_inventory_btn_callback);
            } else if (
              !(
                name_unchanged ||
                desc_unchanged ||
                price_unchanged ||
                qty_unchanged
              )
            ) {
              console.log("All good.");

              const inventory_data = new FormData();
              inventory_data.append("name", product_name_input.value);
              inventory_data.append("desc", product_desc_input.value);
              inventory_data.append("price", product_price_input.value);
              inventory_data.append("qty", product_aqty_input.value);

              updateDB(
                "../inventory/add_inventory_item.php",
                inventory_data,
                (php_response) => {
                  toggle_inventory_btn_callback();

                  cells[0].innerHTML = php_response.id;
                  cells[2].innerHTML = product_name_input.value;
                  cells[3].innerHTML = product_desc_input.value;
                  cells[4].innerHTML = 'N'+product_price_input.value;
                  cells[5].innerHTML = product_aqty_input.value;

                  const action_btn = cells[cells.length - 1].children[0].children;

                  action_btn[0].disabled = false;
                  action_btn[1].disabled = false;

                  product_name_input.remove();
                  product_desc_input.remove();
                  product_price_input.remove();
                  product_aqty_input.remove();
                }
              );
            } else {
              console.log("Dispaly error.");
            }
          },
          "Update Inventory",
          document.getElementById("inventory_btn"),
          "../inventory/update_inventory_item.php",
          editInventoryItem,
          "../inventory/delete_inventory_item.php"
        );

        cells = row.children;

        cells[2].appendChild(product_name_input);
        cells[3].appendChild(product_desc_input);
        cells[4].appendChild(product_price_input);
        cells[5].appendChild(product_aqty_input);
      }

      function editInventoryItem(row) {
        let cells = row.children;

        const id = cells[0].innerHTML;
        const name = cells[2].innerHTML;
        const desc = cells[3].innerHTML;
        const price = cells[4].innerHTML;
        const qty = cells[5].innerHTML;

        const product_name_input = document.createElement("input");
        product_name_input.type = "text";
        product_name_input.value = name;
        const product_desc_input = document.createElement("textarea");
        product_desc_input.value = desc;
        const product_price_input = document.createElement("input");
        product_price_input.type = "number";
        product_price_input.value = price.slice(1);
        const product_aqty_input = document.createElement("input");
        product_aqty_input.type = "number";
        product_aqty_input.value = qty;


        for (let index = 2; index < cells.length - 1; index++) {
          cells[index].innerHTML = "";
        }

        cells[2].appendChild(product_name_input);
        cells[3].appendChild(product_desc_input);
        cells[4].appendChild(product_price_input);
        cells[5].appendChild(product_aqty_input);

        const action_btn = cells[cells.length - 1].children[0].children;

        action_btn[0].innerHTML = "Done";
        const edit_callback = action_btn[0].onclick;
        action_btn[0].onclick = () => {
          const name_unchanged = isUnchanged(product_name_input.value, name);
          const desc_unchanged = isUnchanged(product_desc_input.value, desc);
          const price_unchanged = isZero(product_price_input.value, price);
          const qty_unchanged = isZero(product_aqty_input.value, qty);

          if (name_unchanged) product_name_input.value = name;
          if (desc_unchanged) product_desc_input.value = desc;
          if (price_unchanged) product_price_input.value = price;
          if (qty_unchanged) product_aqty_input.value = qty;

          const inventory_data = new FormData();
          inventory_data.append("name", product_name_input.value);
          inventory_data.append("desc", product_desc_input.value);
          inventory_data.append("price", product_price_input.value);
          inventory_data.append("qty", product_aqty_input.value);
          inventory_data.append("id", id);

          if (
            !(
              name_unchanged &&
              desc_unchanged &&
              price_unchanged &&
              qty_unchanged
            )
          ) {
            updateDB("../inventory/update_inventory_item.php", inventory_data, null);
          }
          cells[2].innerHTML = product_name_input.value;
          cells[3].innerHTML = product_desc_input.value;
          cells[4].innerHTML = 'N'+product_price_input.value;
          cells[5].innerHTML = product_aqty_input.value;

          action_btn[0].innerHTML = "Edit";
          action_btn[0].onclick = edit_callback;
          action_btn[1].disabled = false;

          product_name_input.remove();
          product_desc_input.remove();
          product_price_input.remove();
          product_aqty_input.remove();
        };
        action_btn[1].disabled = true;
      }

      function editInventoryRow(idx) {
        editRow(
          `inventory_table_${idx}`,
          "../inventory/update_inventory_item.php",
          editInventoryItem
        );
      }

      function deleteInventoryRow(idx) {
        deleteRow(`inventory_table_${idx}`, "../inventory/delete_inventory_item.php", null);
      }

    </script>
</body>
</html>
