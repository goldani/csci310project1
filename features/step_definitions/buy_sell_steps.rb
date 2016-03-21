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
end

When(/^the following stock information is input:$/) do |table|
  @buyInfo = table.rows_hash
  driver.find_element(:id, "tickerInput").send_keys(@buyInfo['Ticker'])
  driver.find_element(:id, "qty").send_keys(@buyInfo['Quantity'])
  driver.find_element(:id, "buy-button").click
  #driver.find_elements_by_xpath("//*[contains(text(), 'Buy')]").click
end

When(/^the time in EST is between (\d+)am and (\d+)pm$/) do |startTime, endTime|
  pending
end

Then(/^balance and stock quantity should update$/) do
  pending # Write code here that turns the phrase above into concrete actions
end
