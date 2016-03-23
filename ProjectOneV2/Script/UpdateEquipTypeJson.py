import json
import mysql.connector
import collections
def main():
    cnx = mysql.connector.connect(user='Chochu', password='', host='127.0.0.1', database='nyit')
    cursor = cnx.cursor()
    comm = "SELECT * FROM nyit.equipmenttype;"
    cursor.execute(comm)
    result = cursor.fetchall()

# Convert query to objects of key-value pairs

    objects_list = []
    for row in result:
        d = collections.OrderedDict()
        d['id'] = row[0]
        d['Make'] = row[1]
        d['Model'] = row[2]
        d['Type'] = row[3]
        d['Description'] = row[4]
        objects_list.append(d)

    j = json.dumps(objects_list)
    f = open("G:\wamp\www\ProjectOneV2\Script\JSON\EquipType.json",'w')
    f.write(j)
    cursor.close()
    cnx.close()

if __name__ == "__main__":
    main()
