from random import randint, randrange
import json

# def generate_gallery(cat, path, name, amt):

#   print(f"(NULL, 15,'{name}_1_Card_319_409','./Images/{cat}/{path}/Card/{name}_1_Card_319_409','Card'),")

#   for i in range(1, amt + 1):
#     print(f"(NULL, 15,'{name}_{i}_Gallery_550_550','./Images/{cat}/{path}/Gallery/{name}_{i}_Gallery_550_550','Gallery'),")
  
#   for i in range(1, amt + 1):
#     print(f"(NULL, 15,'{name}_{i}_Thumbnail_100_100','./Images/{cat}/{path}/Thumbnail/{name}_{i}_Thumbnail_100_100','Thumbnail'),")

# generate_gallery("Hamster_Food", "Vitakraft Hamster Treat Stick", "Vitakraft_Hamster_Treat_Stick", 2)

# generate_thumbnail("GREENIES Treatpak Petite Dog Denta Care", "GREENIES_Treatpak_Pette", 3)

# def generate_thumbnail(path, name, amt):

#   for i in range(1, amt + 1):
#     print(f"(NULL,'15','{name}_{amt}_Thumbnail_100_100','./Images/{path}/Thumbnail/{name}_{i}_Thumbnail_100_100','Thumbnail'),")


def numberGenerate():

  numList = []
  for i in range(50):
    num = randint(10000000, 99999999)
    num = str(num)
    num = "1" + num
    num = int(num)
    numList.append(num)
  
  return numList


[{'firstName': 'Mile', 'lastName': 'Bladge', 'email': 'mbladge0@oaic.gov.au', 'userPassword': 'I@mMile69', 'mobileNumber': 121300825}, {'firstName': 'Lise', 'lastName': 'Offord', 'email': 'lofford1@usgs.gov', 'userPassword': 'I@mLise69', 'mobileNumber': 197812988}, {'firstName': 'Aviva', 'lastName': 'Stackbridge', 'email': 'astackbridge2@livejournal.com', 'userPassword': 'I@mAviva69', 'mobileNumber': 161366204}, {'firstName': 'Wilton', 'lastName': 'Wilkie', 'email': 'wwilkie3@cisco.com', 'userPassword': 'I@mWilton69', 'mobileNumber': 135641112}, {'firstName': 'Annalise', 'lastName': 'Lynn', 'email': 'alynn4@irs.gov', 'userPassword': 'I@mAnnalise69', 'mobileNumber': 149442123}, {'firstName': 'Bogart', 'lastName': 'Noriega', 'email': 'bnoriega5@qq.com', 'userPassword': 'I@mBogart69', 'mobileNumber': 140654174}, {'firstName': 'Gottfried', 'lastName': 'Whall', 'email': 'gwhall6@nature.com', 'userPassword': 'I@mGottfried69', 'mobileNumber': 172616611}, {'firstName': 'Angel', 'lastName': 'Costa', 'email': 'acosta7@themeforest.net', 'userPassword': 'I@mAngel69', 'mobileNumber': 184548773}, {'firstName': 'Arlana', 'lastName': 'Housego', 'email': 'ahousego8@webeden.co.uk', 'userPassword': 'I@mArlana69', 'mobileNumber': 173542424}, {'firstName': 'Abigael', 'lastName': 'Sorrill', 'email': 'asorrill9@wix.com', 'userPassword': 'I@mAbigael69', 'mobileNumber': 
181509851}, {'firstName': 'Reade', 'lastName': 'Vawton', 'email': 'rvawtona@house.gov', 'userPassword': 'I@mReade69', 'mobileNumber': 117026825}, {'firstName': 'Tomaso', 'lastName': 'Scoular', 'email': 'tscoularb@mail.ru', 'userPassword': 'I@mTomaso69', 'mobileNumber': 142846578}, {'firstName': 'Dorolice', 'lastName': 'Sauvage', 'email': 'dsauvagec@digg.com', 'userPassword': 'I@mDorolice69', 'mobileNumber': 195948411}, {'firstName': 'Mehetabel', 'lastName': 'Oller', 'email': 'mollerd@rakuten.co.jp', 'userPassword': 'I@mMehetabel69', 'mobileNumber': 183397406}, {'firstName': 'Harri', 'lastName': 'Blasius', 'email': 'hblasiuse@sourceforge.net', 'userPassword': 'I@mHarri69', 'mobileNumber': 171746415}, {'firstName': 'Colline', 'lastName': 'Cherrie', 'email': 'ccherrief@unicef.org', 'userPassword': 'I@mColline69', 'mobileNumber': 149663086}, {'firstName': 'Rikki', 'lastName': 'Chrystie', 'email': 'rchrystieg@w3.org', 'userPassword': 'I@mRikki69', 'mobileNumber': 149864031}, {'firstName': 'Raimundo', 'lastName': 'Hancorn', 'email': 'rhancornh@instagram.com', 'userPassword': 'I@mRaimundo69', 'mobileNumber': 135111824}, {'firstName': 'Shayla', 'lastName': 'De Fries', 'email': 'sdefriesi@instagram.com', 'userPassword': 'I@mShayla69', 'mobileNumber': 152303100}, {'firstName': 'Nevil', 'lastName': 'Ganforthe', 'email': 'nganforthej@netlog.com', 'userPassword': 'I@mNevil69', 'mobileNumber': 145479659}, {'firstName': 'Serena', 'lastName': 'Haruard', 'email': 'sharuardk@mlb.com', 'userPassword': 'I@mSerena69', 'mobileNumber': 162823808}, {'firstName': 'Arabella', 'lastName': 'Ockleshaw', 'email': 'aockleshawl@forbes.com', 'userPassword': 'I@mArabella69', 'mobileNumber': 114031056}, {'firstName': 'Nicol', 'lastName': 'Dugood', 'email': 'ndugoodm@ocn.ne.jp', 'userPassword': 'I@mNicol69', 'mobileNumber': 122357623}, {'firstName': 'Desirae', 'lastName': "O'Fairy", 'email': 'dofairyn@1688.com', 'userPassword': 'I@mDesirae69', 'mobileNumber': 188863958}, {'firstName': 'Hannah', 'lastName': 'Mont', 'email': 'hmonto@google.co.uk', 'userPassword': 'I@mHannah69', 'mobileNumber': 116875049}, {'firstName': 'Peta', 'lastName': 'Roadknight', 'email': 'proadknightp@ebay.co.uk', 'userPassword': 'I@mPeta69', 'mobileNumber': 127669058}, {'firstName': 'Elizabet', 'lastName': 'Kirwood', 'email': 'ekirwoodq@omniture.com', 'userPassword': 'I@mElizabet69', 'mobileNumber': 117043983}, {'firstName': 'Boot', 'lastName': 'Tukely', 'email': 'btukelyr@msu.edu', 'userPassword': 'I@mBoot69', 'mobileNumber': 168354868}, {'firstName': 'Allsun', 'lastName': 'Sympson', 'email': 'asympsons@macromedia.com', 'userPassword': 'I@mAllsun69', 'mobileNumber': 150162580}, {'firstName': 'Arda', 'lastName': 'Messent', 'email': 'amessentt@elpais.com', 'userPassword': 'I@mArda69', 'mobileNumber': 152069206}, {'firstName': 'Gun', 'lastName': 'Cockerton', 'email': 'gcockertonu@theguardian.com', 'userPassword': 'I@mGun69', 'mobileNumber': 163749824}, {'firstName': 'Silva', 
'lastName': 'Bygate', 'email': 'sbygatev@auda.org.au', 'userPassword': 'I@mSilva69', 'mobileNumber': 173677460}, {'firstName': 'Harcourt', 'lastName': 'Rickeard', 'email': 'hrickeardw@vimeo.com', 'userPassword': 'I@mHarcourt69', 'mobileNumber': 144319590}, {'firstName': 'Kale', 'lastName': 'Dallow', 'email': 'kdallowx@irs.gov', 'userPassword': 'I@mKale69', 'mobileNumber': 138869546}, {'firstName': 'Florance', 'lastName': 'Pearcey', 'email': 'fpearceyy@mayoclinic.com', 'userPassword': 'I@mFlorance69', 'mobileNumber': 169440965}, {'firstName': 'Billye', 'lastName': 'Linnane', 'email': 'blinnanez@linkedin.com', 'userPassword': 'I@mBillye69', 'mobileNumber': 187910042}, {'firstName': 'Ted', 'lastName': 'Drieu', 'email': 'tdrieu10@reddit.com', 'userPassword': 'I@mTed69', 'mobileNumber': 142642474}, {'firstName': 'Rivi', 'lastName': 'Alvarado', 'email': 'ralvarado11@xinhuanet.com', 'userPassword': 'I@mRivi69', 'mobileNumber': 175206043}, {'firstName': 'Chucho', 'lastName': 'Garry', 'email': 'cgarry12@freewebs.com', 'userPassword': 'I@mChucho69', 'mobileNumber': 138708169}, {'firstName': 'Maddie', 'lastName': 'Polsin', 'email': 'mpolsin13@nyu.edu', 'userPassword': 'I@mMaddie69', 'mobileNumber': 189695711}, {'firstName': 'Cinderella', 'lastName': 'Glackin', 'email': 'cglackin14@nps.gov', 'userPassword': 'I@mCinderella69', 'mobileNumber': 178366859}, {'firstName': 'Hollie', 'lastName': 'Wellbank', 'email': 'hwellbank15@dot.gov', 'userPassword': 'I@mHollie69', 'mobileNumber': 170144565}, {'firstName': 'Ginni', 'lastName': 'Wyldish', 'email': 'gwyldish16@unicef.org', 'userPassword': 'I@mGinni69', 'mobileNumber': 152343758}, {'firstName': 'Elnora', 'lastName': 'Muzzillo', 'email': 'emuzzillo17@vimeo.com', 'userPassword': 'I@mElnora69', 'mobileNumber': 179741203}, {'firstName': 'Alyson', 'lastName': "O'Kelly", 'email': 'aokelly18@163.com', 'userPassword': 'I@mAlyson69', 'mobileNumber': 195516792}, {'firstName': 'Iseabal', 'lastName': 'Phillipson', 'email': 'iphillipson19@1und1.de', 'userPassword': 'I@mIseabal69', 'mobileNumber': 
132641295}, {'firstName': 'Garrek', 'lastName': 'Varfolomeev', 'email': 'gvarfolomeev1a@wisc.edu', 'userPassword': 'I@mGarrek69', 'mobileNumber': 175482618}, {'firstName': 'Kip', 'lastName': 'Fawson', 'email': 'kfawson1b@digg.com', 'userPassword': 'I@mKip69', 'mobileNumber': 177197287}, {'firstName': 'Arri', 'lastName': 'Garric', 'email': 'agarric1c@spiegel.de', 'userPassword': 'I@mArri69', 'mobileNumber': 187358372}, {'firstName': 'Winslow', 'lastName': 'Sheers', 'email': 'wsheers1d@themeforest.net', 'userPassword': 'I@mWinslow69', 'mobileNumber': 148874569}]


mobileNumber = numberGenerate()
# print(mobileNumber)

# with open("userJson.json", "r") as jsonFile:
#   userJson = json.load(jsonFile)


# for i in userJson:
#   # print(i)
#   print(f"('{i['firstName']}', '{i['lastName']}', '{i['email']}', '{i['userPassword']}', {i['mobileNumber']})," )

#   for i in userJson:
#     i["userPassword"] = f"I@m{i['firstName']}69"

#   for i, m in zip(userJson, mobileNumber):
#     i["mobileNumber"] = m



# with open("sql.json", "w") as writeTo:
#   json.dump(userJson, writeTo)

 
  
# print(userJson)



for i in range(7, 57):
  print(f"({i}, 'CUSTOMER'),")