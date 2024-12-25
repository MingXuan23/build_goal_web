import requests

# URL for the POST request
url = "https://budimadani.gov.my/DaftarAkaun2"

# Headers for the request
headers = {
    "Accept": "*/*",
    "Accept-Encoding": "gzip, deflate, br, zstd",
    "Accept-Language": "en-US,en;q=0.5",
    "Cache-Control": "no-cache",
    "Connection": "keep-alive",
    "Content-Type": "application/x-www-form-urlencoded; charset=utf-8",
    "Cookie": "__AntiXsrfToken=419e6b55ddc04a1588c6b79820ce3b2f; dtCookie=v_4_srv_19_sn_74E2D8F1097F88DF3416808849B6971A_perc_100000_ol_0_mul_1_app-3A2eb7d10dcfcc8530_0; BIGipServerbantuan_diesel_80_pool=1020334508.20480.0000; cookiesession1=678B28B0EF70AAEEF0E31CDB472C1FBD",
    "Host": "budimadani.gov.my",
    "Origin": "https://budimadani.gov.my",
    "Pragma": "no-cache",
    "Priority": "u=0",
    "Referer": "https://budimadani.gov.my/DaftarAkaun2",
    "Sec-Fetch-Dest": "empty",
    "Sec-Fetch-Mode": "no-cors",
    "Sec-Fetch-Site": "same-origin",
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:133.0) Gecko/20100101 Firefox/133.0",
    "x-dtpc": "19$421151855_396h13vQKDAILAGFPNRCCAKKFAUMCUELLOANVVU-0e0",
    "X-MicrosoftAjax": "Delta=true",
    "X-Requested-With": "XMLHttpRequest",
}

# Data for the POST request
data = {
    "ctl00$scriptMgr": "ctl00$MainContent$UpdatePanel1|ctl00$MainContent$semakJPN",
    "__EVENTTARGET": "",
    "__EVENTARGUMENT": "",
    "__VIEWSTATE": "PsmQHt3GtymoGX9fVgRpOpWzaNkxKUfnNFMsoWrRWcNukcvlCTSLUGS3BAwn%2FU%2FmwCJmv6%2FtKnFES3jo9ivgJDbiyTsK8d45cA5AtrmCZl%2BcSpAs7lkvTLGFMILpucxNMnUTupu0aYrkKtSGPXcvlOMi%2F4wW9XqA05TB3EWaPQsA8SpZYLR5wwMYDguLvwN%2F%2B63dMGarRa%2BaVJoHRGr6DDPFs0iskBm2hFcYgDnL%2BS4KBJgb4SvS0GuXNpk%2Fa%2BYnrZqQjNlRghL5cGRO1HJcumCAPYjS317%2BOMfqWAVMzED8IpYQl5b2U%2BJk%2FZdxQB1Sm9JMdFj6pmT%2BvcCbTTDEB8u89Rf2lwNpqB01QAmN9ye%2FKF18Ue6BI5SK%2FblhaMpKUcmQCU5kP5F7SAyaDeLzwIJxD6K71HYbd1XgVUUei1L6Mtbz2TMRTlJ45BiewxymSl435xaDeE3gnr%2F8G9MgrJVoZFGM8iSj0F9FVc%2Fv%2FAHjGS38PM3tTGZ2M4w0UgskMRZALp48%2Bbsw1Y1DAt2AcNHebzYuLFMW5Jz4C5iFlb64ktiaB05GJJVP%2BV6yLQsErkpoGcMz1ZUabH5NecHdBw%3D%3D",
    "__VIEWSTATEGENERATOR": "BD3AFC6C",
    "__SCROLLPOSITIONX": "0",
    "__SCROLLPOSITIONY": "0",
    "__EVENTVALIDATION": "5ZbIPlsnpJBmyroXF7uDom5IyZXLMjAW9nQ8G1kLEVjyKhDNl9gqcscozuwaooYSs3qHVtbjrISJvoP%2BSRbNG63a%2BW0vvnTGOhXUZ6ne%2BequrhGz%2BsHB4rGfd0hMiFMGwiSjWeiopSwbSwj5B3R3mVWBKPpVIRZ4Tevh%2BOxv7nhAyu7DIUbarOYPzuRjrIdILzcQL355szG9bGl1CsV%2BNTq1cpW36dcHhVa8JztsT9nqS%2F88R8%2B9OHI%2Fg%2BAN0IkXFxYaAe9jnK3UfeLjloIRvYcXvs2fd3jEz4O%2FYB4oDYc%3D",
    "ctl00$MainContent$noPengenalan": "941130075153",
    "ctl00$MainContent$namaPenuh": "",
    "ctl00$MainContent$emel": "",
    "ctl00$MainContent$pengesahanEmel": "",
    "ctl00$MainContent$frasaKeselamatan": "",
    "ctl00$MainContent$Password": "",
    "ctl00$MainContent$confirmPassword": "",
    "__ASYNCPOST": "true",
    "ctl00$MainContent$semakJPN": "Semak Nama",
}

# Make the POST request
response = requests.post(url, headers=headers, data=data)

# Print the response
print("Status Code:", response.status_code)
print("Response Text:", response.text)
