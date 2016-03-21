driver = Selenium::WebDriver.for :firefox

@marketClosed = false

Given(/^user is logged in:$/) do |table|
  driver.navigate.to("http://localhost")
  @userCredentials = table.rows_hash
  driver.find_element(:id, "login-username").send_keys(@userCredentials['username'])
  driver.find_element(:id, "login-password").send_keys(@userCredentials['password'])
  driver.find_element(:id, "login-submit").click
  currentURL = driver.current_url
  expect(currentURL).to eq("http://localhost/mainpage.php")
end

When(/^the following stock is searched:$/) do |table|
  @stock = table.rows_hash
  driver.find_element(:id, "search-box").clear()
  driver.find_element(:id, "search-box").send_keys(@stock['Stock'])
end

Then(/^searched stock should be in the drop down:$/) do |table|
    # driver.manage.timeouts.implicit_wait = 20 # seconds
    sleep(5.0)
    @stockInfo = table.rows_hash
    resultStock = driver.find_element(:class, 'menu-item').text
    expect(resultStock).to eq(@stockInfo['FullName'])
    # true
end

Then(/^drop down should be empty:$/) do
    driver.manage.timeouts.implicit_wait = 5 # seconds
    resultStock = driver.find_element(:class, 'menu-item').text
end
