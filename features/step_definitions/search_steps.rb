driver = Selenium::WebDriver.for :firefox

@marketClosed = false

Given(/^user is logged in:$/) do |table|
  driver.navigate.to("http://stockoverflow.com")
  @userCredentials = table.rows_hash
  driver.find_element(:id, "login-username").send_keys(@userCredentials['username'])
  driver.find_element(:id, "login-password").send_keys(@userCredentials['password'])
  driver.find_element(:id, "login-submit").click
  currentURL = driver.current_url
  expect(currentURL).to eq("http://stockoverflow.com/mainpage.php")
end

When(/^the following ticker symbol is searched:$/) do |table|
  @stockTicker = table.rows_hash
  driver.find_element(:id, "search-box").send_keys(@stockTicker['Ticker'])
end

Then(/^searched stock should be in the drop down$/) do
    driver.manage.timeouts.implicit_wait = 20 # seconds


    resultStock = driver.find_elements(:class, 'menu-item')
    expect(resultStock).to eq("SEED - Origin Agritech Limited")
end
