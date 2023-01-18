import redis
import sys

r = redis.Redis('localhost', 6379, charset="utf-8", decode_responses=True)
user = sys.argv[1]


def setUserSession(user):
    r.set(f"{user}-count", 1)
    r.set(f"{user}-time", "is not expired")
    r.expire(f"{user}-time", 600)
    r.set(user, 1)


def getUserSession(user):
    return {"timeout": r.get(f"{user}-time"), "count": r.get(f"{user}-count")}


def incrementUserSession(user):
    r.incr(f"{user}-count")


userSession = getUserSession(user)
sessionTimeout = userSession["timeout"]
sessionCount = int(userSession["count"])

if sessionTimeout == None:
    setUserSession(user)
    print("Nombre de connexions restantes : 9")
else:
    if sessionCount < 10:
        incrementUserSession(user)
        print(f"Nombre de connexions restantes : {10 - (sessionCount + 1)}")
    else:
        print(
            f"Vous vous êtes connecté plus de 10 fois, réessayez dans {r.ttl(user+'-time') // 60} minutes.")

sys.exit(8)
