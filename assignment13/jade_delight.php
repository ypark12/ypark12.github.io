<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Assignment13</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script language="javascript">
		itemNames = [];
		itemCosts = [];
	</script>
</head>

<body>
	<script language="javascript">
		function makeSelect(name, minRange, maxRange) {
			var t = "";
			t = "<select name='" + name + "' size='1'>";
			for (j = minRange; j <= maxRange; j++)
				t += "<option>" + j + "</option>";
			t += "</select>";
			return t;
		}
	</script>

	<?php

	include "db_connect.php";

	//select the database
	$conn->select_db($db);
	
	//run a query
	$sql = "SELECT * FROM product";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_array()) {
			$item_name = $row[1];
			$item_cost = $row[2];

			// add the items to the array
			echo "<script language='javascript'>itemNames.push('$item_name')</script>";
			echo "<script language='javascript'>itemCosts.push('$item_cost')</script>";
		}
	} else {
		echo "no results";
	}

	//close the connection	
	$conn->close();

	?>

	<h1>Jade Delight</h1>

	<form name="data" onsubmit="return validate()" method="get" action="process.php">
		<p>First Name: <input type="text" name='fname' /></p>
		<p>Last Name*: <input type="text" name='lname' /></p>
		<p>Email*: <input type="text" name='eaddress' /></p>
		<div id="delivery_address" style="display: none;">
			<p>Street: <input type="text" name='street' /></p>
			<p>City: <input type="text" name='city' /></p>
		</div>

		<p>Phone*: <input type="text" name='phone' /></p>
		<p>
			<input type="radio" name="p_or_d" value="pickup" checked="checked" /> Pickup
			<input type="radio" name='p_or_d' value='delivery' /> Delivery
		</p>

		<table border="0" cellpadding="3">
			<tr>
				<th>Select Item</th>
				<th>Item Name</th>
				<th>Cost Each</th>
				<th>Total Cost</th>
			</tr>

			<script language="javascript">
				var s = "";
				for (i = 0; i < 5; i++) {
					s += "<tr><td>";
					s += makeSelect("quan" + i, 0, 10) + "</td>";

					s += "<td>" + itemNames[i] + "</td>";
					s += "<td> $" + parseFloat(itemCosts[i]).toFixed(2) + "</td>";
					s += "<td>$<input type='text' name='cost'/></td></tr>";
				}
				document.writeln(s);
			</script>
		</table>

		<p>Subtotal: $<input type="text" name='subtotal' id="subtotal" /></p>

		<p>Mass tax 6.25%: $ <input type="text" name='tax' id="tax" /></p>

		<p>Total: $ <input type="text" name='total' id="total" /></p>

		<input type="submit" name="submit" value="Submit Order"/>

		<input type="text" name="message" id="message" style="display: none"/>

	</form>
	<script>
		// Pickup or Delivery: 
		window.onload = $("[name='p_or_d']").click(function() {
			if ($(this).val() == 'pickup') {
				$("[name='p_or_d'][value='pickup']").attr('checked', true);
				$("[name='p_or_d'][value='delivery']").attr('checked', false);
				document.getElementById("delivery_address").style.display = "none";
			} else {
				$("[name='p_or_d'][value='pickup']").attr('checked', false);
				$("[name='p_or_d'][value='delivery']").attr('checked', true);
				document.getElementById("delivery_address").style.display = "block";
			}
		});

		// When a user selects a quantity: 
		window.onload = $('select').on('change', function() {
			with(document.data) {
				var arr_cost = cost;
				var subtotal_price = 0;

				for (var i = 0; i < 5; i++) {
					var temp = "quan" + i;
					var menu_item = $("[name='" + temp + "']");

					if (menu_item.val() != 0) {
						var item_cost = parseInt(menu_item.val()) * itemCosts[i];
						cost[i].value = item_cost.toFixed(2);
					} else {
						cost[i].value = "";
					}
					subtotal_price += parseFloat(cost[i].value) || 0;
				}

				subtotal.value = parseFloat(subtotal_price).toFixed(2);
				tax.value = parseFloat(subtotal_price * 0.0625).toFixed(2);
				total.value = (parseFloat(tax.value) + parseFloat(subtotal.value)).toFixed(2);

				if (total.value == 0) {
					subtotal.value = "";
					tax.value = "";
					total.value = "";
				}
			}
		});

		function email_check() {
			var email_address = $("[name='eaddress']").val();
			if (email_address == "") {
				alert("Please a valid email.");
				return false;
			}
			return true;
		}

		function name_check() {
			// Check if last name and phone numbers are entered:
			var last_name = $("[name='lname']").val();
			if (last_name == "") {
				alert("Please enter your last name.");
				return false;
			}
			var regex = /^[a-zA-Z]+$/;
			if (!last_name.match(regex)) {
				alert("Please enter alphabet letters for your last name.");
				return false;
			}
			return true;
		}

		function number_check() {
			var phone_number = $("[name='phone']").val();
			if (phone_number == "") {
				alert("Please enter your phone number.");
				return false;
			}

			// Check phone number validity: 
			// 1. is input a number
			if (isNaN(phone_number)) {
				alert("Please enter numbers for your phone number.\nDo not put hyphens (-) between your numbers.");
				return false;
			}
			// 2. is a phone number valid in the US?: 10 digits
			if (phone_number.toString().length != 10) {
				alert("Please enter a valid US phone number.\nThe numbers must be 10 digits.");
				return false;
			}
			return true;
		}

		function order_check() {
			if ($("[name='total']").val() == "") {
				alert("You must order at least one item to submit order.");
				return false;
			}
			return true;
		}

		function print_order(delivery_time) {
			message.value = "<div style= 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);  text-align: center;'>"
			message.value += "<div><p style='font-size: 20px; font-weight: 700;'>Thank you for your order.</p></div>";
			message.value += "<div>You have ordered: </div>";

			for (var i = 0; i < 5; i++) {
				var temp = "quan" + i;
				var menu_item = $("[name='" + temp + "']");

				if (menu_item.val() != 0) {
					message.value += "<div>" + menu_item.val() + " " + itemNames[i] + "</div>";
				}
			}
			message.value += "<br>";
			message.value += "<div>The estimated " + $("[name='p_or_d']:checked").val() + " time is " + delivery_time + " minutes.</div>";
			message.value += "<div>The subtotal price is $" + subtotal.value + ".</div>";
			message.value += "<div>The tax price is $" + tax.value + ".</div>";
			message.value += "<div>The total price is $" + total.value + ".</div>";
			message.value += "<p>Always yours, </p>";
			message.value += "<p style='font-size: 16px; font-weight: 700;'>Jade Delight</p></div>";
			console.log(message.value);
		}

		function validate() {
			if (!email_check()) return false;
			if (!name_check()) return false;
			if (!number_check()) return false;

			var delivery_time = 0;
			if ($("[name='p_or_d']:checked").val() == "pickup") {
				delivery_time = 15;
			} else {
				delivery_time = 30;
				if ($("[name='street']").val() == "" || $("[name='city']").val() == "") {
					alert("Please enter your Street and City address.");
					return false;
				}
			}

			if (!order_check()) return false;

			print_order(delivery_time);

			return true;
		}
	</script>

</body>

</html>