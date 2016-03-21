

driver = Selenium::WebDriver.for :firefox
@marketClosed = false

Given(/^user is logged in on the dashboard:$/) do |table|
  driver.navigate.to("http://localhost")
  @userCredentials = table.rows_hash
  driver.find_element(:id, "login-username").send_keys(@userCredentials['username'])
  driver.find_element(:id, "login-password").send_keys(@userCredentials['password'])
  driver.find_element(:id, "login-submit").click
  currentURL = driver.current_url
  expect(currentURL).to eq("http://localhost/mainpage.php")

  #initial balance
balanceElement = driver.find_element(:id, "balance")
@initialBalance = driver.execute_script("return arguments[0].innerHTML;", balanceElement)
end

When(/^the following stock information is input:$/) do |table|
  @buyInfo = table.rows_hash
  driver.find_element(:id, "tickerInput").send_keys(@buyInfo['Ticker'])
  driver.find_element(:id, "qty").send_keys(@buyInfo['Quantity'])
  driver.find_element(:id, "buy-button").click
end

When(/^the time in EST is between (\d+)am and (\d+)pm$/) do |startTime, endTime|
	element = driver.find_element(:id, "clock")
	time = driver.execute_script("return arguments[0].innerHTML;", element)
	timeArray = time.split(/[\s:]/)

	#wait longer for button to load
	driver.manage.timeouts.implicit_wait = 3
	puts timeArray[0]
	puts timeArray[3]

	if (timeArray[0].to_i >= startTime.to_i && timeArray[0].to_i != 12 && timeArray[3] == "AM") || (timeArray[0].to_i <= endTime.to_i && timeArray[3] == "PM") || (timeArray[0].to_i == 12 && timeArray[3] == "PM")
		puts "Market open"
		driver.find_element(:id, "confBtn").click
		#wait longer for button to appear
		driver.manage.timeouts.implicit_wait = 10
		driver.find_element(:id, "clsBtn").click
	else
		puts "Market closed"
		@marketClosed = true
		
		driver.find_element(:id, 'clsBtn').click

	end
end

Then(/^balance and stock quantity should update$/) do
	if @marketClosed
		puts "Market closed, can't buy"
	else
		element = driver.find_element(:id, "balance")
		@newBalance = driver.execute_script("return arguments[0].innerHTML;", element)
		expect(@newBalance).not_to eq(@initialBalance)
	end

	driver.close
end
