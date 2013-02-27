import sys
import operator

sys.setrecursionlimit(100000)

f = open('data/SCC.txt')
lines = [line.strip() for line in f]
f.close()
#print lines, len(lines)

e_f = []
e_r = []
v = []
tl = []
l = []

leader = 0;
timelife = 0

for line in lines:
    vert = line.split()
    v_index = int(vert[0])
    
    if len(v) < v_index:
        while len(v) < v_index:
            v.append(0)
            e_r.append([])
            e_f.append([])

        for head in vert[1:]:
            e_f[v_index - 1].append(int(head)-1)
        
for head in range(len(e_f)):
    for tail in e_f[head]:
        e_r[tail].append(head)       

l = [0]*len(v)
tl = [0]*len(v)

def dfs (start, direction) :
    global e_f, e_r, v, tl, leader, timelife  
    #print start   
    v[start] = 1
    l[start] = leader;
    edges = e_f if direction == 'f' else e_r

    for edge in edges[start]:
        if v[edge] != 1:
            dfs(edge, direction)
            
    if direction == 'b':
        tl[timelife] = start;
        timelife+=1
        
    return 
    
def dfs_loop() :
    global tl, v, leader, timelife;
    
    for start in range(len(v)-1, -1, -1):
        if v[start] == 0:
            dfs(start, 'b')
            
    v = [0]*len(v)
    
    for start in range(len(tl)-1, -1, -1):
        leader = start
        if v[tl[start]] == 0:
            dfs(tl[start], 'f')

dfs_loop()

zones = {};

for leader in l:
    if not zones.has_key(leader) :
        zones.update({leader: 0})
    zones[leader] += 1

i = 0    
for w in sorted(zones, key=zones.get, reverse=True):
    if i < 5 :
        print zones[w]
        i += 1
