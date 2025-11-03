USE RealEstate;
-- 1
SELECT H.address
FROM House H
         JOIN Listings L ON H.address = L.address;

-- 2
SELECT H.address, L.mlsNumber
FROM House H
         JOIN Listings L ON H.address = L.address;

-- 3
SELECT H.address
FROM House H
         JOIN Listings L ON H.address = L.address
WHERE H.bedrooms = 3 AND H.bathrooms = 2;

-- 4
SELECT H.address, P.price
FROM House H
         JOIN Property P ON H.address = P.address
         JOIN Listings L ON H.address = L.address
WHERE H.bedrooms = 3
  AND H.bathrooms = 2
  AND P.price BETWEEN 100000 AND 250000
ORDER BY P.price DESC;

-- 5
SELECT BP.address, P.price
FROM BusinessProperty BP
         JOIN Property P ON BP.address = P.address
         JOIN Listings L ON BP.address = L.address
WHERE BP.type = 'Office Space'
ORDER BY P.price DESC;

-- 6
SELECT A.agentId, A.name, A.phone, F.name AS firmName, A.dateStarted
FROM Agent A
         JOIN Firm F ON A.firmId = F.id;

-- 7
SELECT P.address, P.ownerName, P.price
FROM Property P
         JOIN Listings L ON P.address = L.address
WHERE L.agentId = 101;

-- 8
SELECT A.name AS AgentName, B.name AS BuyerName
FROM Agent A
         JOIN Works_With WW ON A.agentId = WW.agentId
         JOIN Buyer B ON WW.buyerId = B.id
ORDER BY A.name ASC;

-- 9
SELECT A.agentId, COUNT(WW.buyerId) AS BuyerCount
FROM Agent A
         LEFT JOIN Works_With WW ON A.agentId = WW.agentId
GROUP BY A.agentId;

-- 10
SELECT H.address, P.price
FROM Buyer B
         JOIN House H ON B.propertyType = 'House'
         JOIN Property P ON H.address = P.address
WHERE B.id = 201
  AND H.bedrooms = B.bedrooms
  AND H.bathrooms = B.bathrooms
  AND P.price BETWEEN B.minimumPreferredPrice AND B.maximumPreferredPrice
ORDER BY P.price DESC;
