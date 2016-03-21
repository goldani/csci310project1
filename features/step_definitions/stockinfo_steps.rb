driver = Selenium::WebDriver.for :firefox

Given(/^user is logged in to dash:$/) do |table|
  driver.navigate.to("http://localhost")
  @userCredentials = table.rows_hash
  driver.find_element(:id, "login-username").send_keys(@userCredentials['username'])
  driver.find_element(:id, "login-password").send_keys(@userCredentials['password'])
  driver.find_element(:id, "login-submit").click
  currentURL = driver.current_url
  expect(currentURL).to eq("http://localhost/mainpage.php")
end

When(/^a stock from left side is clicked:$/) do
  tableBody = driver.find_element(:id, "portfolio-body")
  # a = driver.find_element(:id, "tickerInput")
  randomLine = tableBody.find_element(:tag_name, "tr")
  randomLine.click
  @ticker = randomLine.find_element(:tag_name, "td").text
end

Then(/^the clicked stock's info should be displayed:$/) do
    # driver.manage.timeouts.implicit_wait = 20 # seconds
    sleep(3.0)
    resultStock = driver.find_element(:id, 'stockinfo1').text
    elements = resultStock.split(" ")
    expect(@ticker).to eq(elements[1])
    # true
end
