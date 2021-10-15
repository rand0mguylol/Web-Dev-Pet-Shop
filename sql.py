def generate_gallery(cat, path, name, amt):

  print(f"(NULL, 15,'{name}_1_Card_319_409','./Images/{cat}/{path}/Card/{name}_1_Card_319_409','Card'),")

  for i in range(1, amt + 1):
    print(f"(NULL, 15,'{name}_{i}_Gallery_550_550','./Images/{cat}/{path}/Gallery/{name}_{i}_Gallery_550_550','Gallery'),")
  
  for i in range(1, amt + 1):
    print(f"(NULL, 15,'{name}_{i}_Thumbnail_100_100','./Images/{cat}/{path}/Thumbnail/{name}_{i}_Thumbnail_100_100','Thumbnail'),")

generate_gallery("Hamster_Food", "Vitakraft Hamster Treat Stick", "Vitakraft_Hamster_Treat_Stick", 2)

# generate_thumbnail("GREENIES Treatpak Petite Dog Denta Care", "GREENIES_Treatpak_Pette", 3)

# def generate_thumbnail(path, name, amt):

#   for i in range(1, amt + 1):
#     print(f"(NULL,'15','{name}_{amt}_Thumbnail_100_100','./Images/{path}/Thumbnail/{name}_{i}_Thumbnail_100_100','Thumbnail'),")


