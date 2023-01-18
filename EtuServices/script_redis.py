import redis
import sys

r = redis.Redis()
user = sys.argv[1]


def setUserSession(user):
    r.set(f"{user}-count", 1)
    r.set(f"{user}-time", "is not expired")
    r.expire(f"{user}-time", 600)
    return r.set(user, 1)


def getUserSession(user):
    return {"timeout": r.get(f"'{user}-time"), "count": r.get(f"{user}-count")}


def incrementUserSession(user):
    return r.incr(user)


userSession = getUserSession(user)
sessionTimeout = userSession["timeout"]
sessionCount = userSession["count"]

if (sessionTimeout == None):
    setUserSession(user)
    print(1)
else:
    if (sessionCount <= 10):
        incrementUserSession(user)
        print(sessionCount)
    else:
        print(sessionCount)
